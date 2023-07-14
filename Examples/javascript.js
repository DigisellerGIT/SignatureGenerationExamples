const axios = require('axios')
const crypto = require('crypto')
const sha256 = crypto.createHash('sha256')

async function getToken(sellerId, apiKey) {
    const url = 'https://api.digiseller.ru/api/apilogin'
    const timestamp = parseInt(Date.now() / 1000)
    const sign = sha256.update('' + apiKey + timestamp).digest('hex');
    const res = await axios({
        method: 'post',
        url,
        data: {
            "seller_id": sellerId,
            "timestamp": timestamp,
            "sign": sign
        },
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    return {
        status: res.status,
        data: res.data
    }
}

(async function () {
    const sellerId = 12126
    const apiKey = 'E2AF00CBE6A24E06B1C1952E239A4B61'
    const res = await getToken(sellerId, apiKey)
    console.log(res)
})()