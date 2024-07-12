# Usa a imagem base do Lambda com Python 3.8
FROM --platform=linux/amd64 amazon/aws-lambda-python:3.8

# Instala o módulo awslambdaric
RUN pip install awslambdaric sqlalchemy pymysql redis pusher

RUN yum install -y nano

# Copia o código da função Lambda 
COPY lambda_function.py ${LAMBDA_TASK_ROOT}



# Define o entrypoint e o comando padrão


CMD ["lambda_function.handler"]
