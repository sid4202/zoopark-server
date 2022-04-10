import requests

text = requests.get('http://localhost:8000/animals').text
if text == "[]":
    print("OK")
else:
    print("Not OK")

text = requests.post('http://localhost:8000/animal', '{"name":"Melman","type":"giraffe"}').text
if text:
    print("OK")
else:
    print("Not OK")

text = requests.get('http://localhost:8000/animal/1').text
if text != "null":
    print("OK")
else:
    print("Not OK")