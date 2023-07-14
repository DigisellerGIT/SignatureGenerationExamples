import hashlib
import requests
import time

def get_token(seller_id, api_key):
    timestamp = int(time.time())
    data = api_key + str(timestamp)
    sign = hashlib.sha256(data.encode('utf-8')).hexdigest()
    json = {
        "seller_id": seller_id,
        "timestamp": timestamp,
        "sign": sign
    }
    url = 'https://api.digiseller.ru/api/apilogin'
    headers = {'Content-Type': 'application/json', 'Accept': 'application/json'}
    r = requests.post(url, json=json, headers=headers)
    if r.status_code != 200:
        return None
    res = r.json()
    if res['retval'] != 0:
        return None
    return res['token']

if __name__ == '__main__':
    seller_id = 12126
    api_key = 'E2AF00CBE6A24E06B1C1952E239A4B61'
    token = get_token(seller_id, api_key)
    print(token)