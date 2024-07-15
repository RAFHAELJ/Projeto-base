import json
from lambda_function import handler

# Simular evento e contexto
event = {}
context = {}

# Chamar a função handler
response = handler(event, context)

# Imprimir o resultado
print(json.dumps(response, indent=4))
