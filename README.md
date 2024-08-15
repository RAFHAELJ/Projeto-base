# Projeto Base - Controle de Sprint com Chat Integrado

Este projeto é uma **prova de conceito (PoC)** que demonstra um sistema de controle de sprint integrado com um chat, permitindo a comunicação entre membros da equipe separados por setores. O projeto também inclui o controle automático da porcentagem de progresso das sprints, realizado por uma função **Lambda** que verifica se o projeto está dentro do cronograma e notifica em caso de atrasos. A comunicação em tempo real entre desenvolvedores é possível através do chat integrado.

**Obs:** Este projeto está em desenvolvimento. Qualquer falha pode ser informada para melhoria.

## Tecnologias Utilizadas

- **Laravel**: Estrutura principal do projeto.
- **MySQL**: Banco de dados relacional utilizado para o controle robusto das tabelas de projetos, usuários, tarefas e sprints, facilitando a integração e a futura implantação de relatórios.
- **MongoDB**: Banco de dados NoSQL utilizado para armazenar o histórico de conversas do chat, aproveitando sua velocidade e capacidade de adicionar novas colunas dinamicamente.
- **Redis**: Utilizado para emular WebSockets e proporcionar comunicação em tempo real no chat.
- **AWS Lambda (emulada)**: Utilizada para o controle automático de progresso das sprints e notificações de atrasos.
- **Docker**: Todo o ambiente foi projetado em Docker, incluindo a emulação da Lambda, para facilitar a visualização e demonstrar a robustez da aplicação.

## Instruções de Instalação

1. **Clone o repositório para sua máquina local**:
    ```bash
    git clone https://github.com/seu-usuario/seu-repositorio.git
    ```

2. **Acesse a pasta do projeto**:
    ```bash
    cd Projeto-base
    ```

3. **Construa as imagens Docker**:
    ```bash
    docker compose build
    ```
    _Nota: Este processo pode levar algum tempo._

4. **Inicie o projeto**:
    ```bash
    docker compose up -d
    ```

5. **Interaja com o código dentro do contêiner PHP**:
    ```bash
    docker compose exec -it php-container bash
    ```

6. **Para finalizar o ambiente Docker**:
    ```bash
    docker compose down
    ```

## Acesso à Aplicação

- **URL de acesso**: [http://localhost:8084/login](http://localhost:8084/login)

## Agendamento de Tarefas

Para acionar o cron e verificar os atrasos automaticamente, use o comando:

```bash
php artisan schedule:run
