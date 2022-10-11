# Ratings

---

- [Average](#average)


### Model

Parameter | Type | Description
--------- | ---- | -----------
average | integer | The average rating value.
count | integer | The count of rates included in average rating calculation.

<a name="average"></a>
## Average

This endpoint provides users/clients average rating in TMS (default last 100 record).

### HTTP Request

`GET https://{environment}.synega.com/api/v3/ratings/average`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
type | string | **Yes** | The type of rates (from **client** to user or from **user** to client).
client_id | integer | No | The unique ID of the specific client.
user_id | integer | No | The unique ID of the specific user.
limit | integer | No | The number of rates included in average rating calculation.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/ratings/average \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "type": "client"
    }'
```

### Example Response

```json
{
  "data": {
    "average": 3,
    "count": 4
  }
}
```
