import requests


def empty_check():
    text = requests.get('http://localhost:8000/animals').text
    if text == "[]":
        return True
    else:
        print(text)
        return False


def post_animal_check():
    text = requests.post('http://localhost:8000/animal', '{"name":"Melman","type":"giraffe"}').text
    if text:
        return True
    else:
        print(text)
        return False


def get_animal_check():
    text = requests.get('http://localhost:8000/animal/1').text
    if text != "null":
        return True
    else:
        print(text)
        return False


def wrong_animal_check():
    text = requests.get('http://localhost:8000/animal/1927353').text
    if text != "null":
        return True
    else:
        print(text)
        return False


def post_weirdName_animal():
    text = requests.post('http://localhost:8000/animal', '{"name":"Melman","type":"/+=-&giraffe"}').text
    if text:
        return True
    else:
        print(text)
        return False


def correct_deletion_check():
    text = requests.delete('http://localhost:8000/animal/1').text
    if text == "deleted":
        return True
    else:
        print(text)
        return False


arr = [empty_check, post_animal_check, wrong_animal_check, post_weirdName_animal, correct_deletion_check]

for test in arr:
    result = test()
    if result:
        print("ok")
    else:
        print("not ok")