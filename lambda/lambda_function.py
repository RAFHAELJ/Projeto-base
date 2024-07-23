
from sqlalchemy import create_engine, Column, Integer, String, Boolean, ForeignKey, Float, TIMESTAMP
from sqlalchemy.orm import sessionmaker, relationship, declarative_base
from datetime import datetime, timedelta
import requests

# Configurar a conexão com o banco de dados
DATABASE_URL = "mysql+pymysql://root:master@mysql:3306/poc_db"
engine = create_engine(DATABASE_URL)
Session = sessionmaker(bind=engine)
session = Session()
Base = declarative_base()

# Definir as tabelas
class Tarefa(Base):
    __tablename__ = 'tarefas'
    id = Column(Integer, primary_key=True)
    title = Column(String)
    description = Column(String)
    user_id = Column(Integer)
    is_completed = Column(Boolean, default=False)
    percentage = Column(Float, default=0.0)
    created_at = Column(TIMESTAMP)
    days = Column(Integer)
    subtarefas = relationship("Subtarefa", back_populates="tarefa")

class Subtarefa(Base):
    __tablename__ = 'subtarefas'
    id = Column(Integer, primary_key=True)
    title = Column(String)
    description = Column(String)
    is_completed = Column(Boolean, default=False)
    task_id = Column(Integer, ForeignKey('tarefas.id'))
    tarefa = relationship("Tarefa", back_populates="subtarefas")

# Função para calcular a porcentagem de subtarefas concluídas e atualizar a tarefa
def atualizar_percentagem_tarefas_nao_concluidas():
    tarefas_nao_concluidas = session.query(Tarefa).filter(Tarefa.is_completed == False).all()
    for tarefa in tarefas_nao_concluidas:
        total_subtarefas = len(tarefa.subtarefas)
        if total_subtarefas == 0:
            tarefa.percentage = 0.0
        else:
            subtarefas_concluidas = sum(1 for subtarefa in tarefa.subtarefas if subtarefa.is_completed)
            tarefa.percentage = (subtarefas_concluidas / total_subtarefas) * 100

        # Atualiza o status da tarefa se todas as subtarefas estão concluídas
        if subtarefas_concluidas == total_subtarefas:
            tarefa.is_completed = True

    session.commit()
    print("Percentagens atualizadas para todas as tarefas não concluídas")

# Função para verificar atrasos nas tarefas
def verificar_atrasos():
    hoje = datetime.now()
    tarefas = session.query(Tarefa).filter(Tarefa.is_completed == False).all()
    for tarefa in tarefas:
        dias_estipulados = tarefa.days
        percentage = tarefa.percentage
        user_id = tarefa.user_id
        created_at = tarefa.created_at
        data_conclusao_estimada = created_at + timedelta(days=dias_estipulados)

        # Calcular prazo limite para 50% do tempo
        prazo_limite_50_percent = created_at + timedelta(days=dias_estipulados / 2)

        # Verificar se está dentro do cronograma
        if (hoje <= prazo_limite_50_percent and percentage >= 70): 
            print(f"Tarefa {tarefa.id} com usuário {user_id} está dentro da métrica.")
        else:
            print(f"Tarefa {tarefa.id} com usuário {user_id} não atingiu a métrica.")
            mensagem = f"Tarefa {tarefa.title} não atingiu a métrica. Porcentagem de subtarefas concluída e já passou 50% do prazo."
            
            # Enviar mensagem para a rota Laravel
            url = 'http://php/py/messages'  
            data = {
                'user_id_py': int(user_id),
                'message': mensagem,
                'destination_id': int(user_id)
            }

            response = requests.post(url, data=data)
            if response.status_code == 200:
                print(f"Mensagem enviada com sucesso para usuário {user_id}.")
            else:
                print(f"Falha ao enviar mensagem para usuário {user_id}. Status code: {response.status_code}")

# Handler para a função Lambda
def handler(event, context):
    
    message = event.get('message', '')
    
    if message == 'gerenciar':
        verificar_atrasos()
    else:
        atualizar_percentagem_tarefas_nao_concluidas()
    
    return {
        'statusCode': 200,
        'body': 'Processo concluído com sucesso!'
    }


if __name__ == "__main__":
    
    event = {'message': 'gerenciar'}
    handler(event, {})
