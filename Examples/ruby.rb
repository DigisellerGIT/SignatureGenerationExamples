require 'digest/sha2'
require 'json'
require 'net/http'
require 'uri'

def get_token(seller_id, api_key)
    timestamp = Time.now.to_i
    sign = Digest::SHA2.hexdigest(api_key + timestamp.to_s)
    data = {
        "seller_id" => seller_id,
        "timestamp" => timestamp,
        "sign" => sign
    }
    uri = URI('https://api.digiseller.ru/api/apilogin')
    https = Net::HTTP.new(uri.host, uri.port)
    https.use_ssl = true
    request = Net::HTTP::Post.new(uri.path)
    request['Content-Type'] = 'application/json'
    request['Accept'] = 'application/json'
    response = https.request(request, data.to_json)
    return {
        status: response.code.to_i,
        data: JSON.parse(response.body)
    }
end

seller_id = 12126
api_key = 'E2AF00CBE6A24E06B1C1952E239A4B61'
res = get_token(seller_id, api_key)
puts JSON.pretty_generate(res)