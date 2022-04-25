import requests
import json


def empty_check():
    requests.delete('http://localhost:8000/animals')

    text = requests.get('http://localhost:8000/animals').text

    if text == "[]":
        return True
    else:
        print(text)
        return False


def post_animal_check():
    text = requests.post('http://localhost:8000/animal', '{"name":"Melman","type":"giraffe"}').text

    correct_text_result = json.loads('{"name":"Melman","type":"giraffe"}')

    text_result = json.loads(text)

    if text_result["name"] == correct_text_result["name"] and text_result["type"] == correct_text_result["type"]:
        return True
    else:
        print(text)
        return False


def get_animal_check():
    requests.delete('http://localhost:8000/animals')

    requests.post('http://localhost:8000/animal', '{"name":"Melman","type":"giraffe"}')

    # TODO make GET request to check animal

    correct_text_result = json.loads('{"name":"Melman","type":"giraffe"}')

    text_result = json.loads(text)

    if text_result["name"] == correct_text_result["name"] and text_result["type"] == correct_text_result["type"]:
        return True
    else:
        print(text)
        return False


def wrong_animal_check():
    text = requests.get('http://localhost:8000/animal/1927353').text

    if text != "null":
        print(text)
        return False
    else:
        return True


def post_weird_name_animal():
    requests.delete('http://localhost:8000/animals')

    text = requests.post('http://localhost:8000/animal', '{"name":"Melman","type":"/+=-&giraffe"}').text

    text_arr = json.loads(text)

    if text_arr["name"] == "Melman" and text_arr["type"] == "/+=-&giraffe":
        return True
    else:
        print(text)
        return False


def correct_deletion_check():
    text = requests.delete('http://localhost:8000/animal/1').text

    # TODO add GET query to check animal is really deleted

    if text == "deleted":
        return True
    else:
        print(text)
        return False


def correct_update_check():
    requests.delete('http://localhost:8000/animals')

    requests.post('http://localhost:8000/animal', '{"name":"Melman","type":"giraffe"}')

    response = requests.put('http://localhost:8000/animal/1', '{"name":"Pablo","type":"giraffe"}')

    text = json.loads(response.text)

    if text["name"] == "Pablo":
        return True
    else:
        print(text)
        return False


def correct_get_3_animals_check():
    requests.delete('http://localhost:8000/animals')

    for i in range(3):
        requests.post('http://localhost:8000/animal', '{"name":"Melman","type":"giraffe"}')

    all_animals = json.loads(requests.get('http://localhost:8000/animals').text)

    if len(all_animals) == 3:
        return True
    else:
        print(text)
        return False


def wrong_animal_deletion_check():
    text = requests.delete('http://localhost:8000/animal/23445667')

    if not text:
        return True
    else:
        print(text)
        return False


arr = [
    empty_check,
    post_animal_check,
    wrong_animal_check,
    post_weird_name_animal,
    correct_deletion_check,
    wrong_animal_deletion_check,
    correct_get_3_animals_check,
    correct_update_check
]

for test in arr:
    result = test()
    if result:
        print("ok")
    else:
        print(f"not ok: {test}")
