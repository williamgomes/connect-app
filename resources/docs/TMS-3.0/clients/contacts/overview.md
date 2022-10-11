# Contacts

---

- [Index](#index)
- [Link](#link)
- [Unlink](#unlink)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the contact object.
active | boolean | Determines if the contact is active or not.
for_all_clients | boolean | Determines if the contact is for all clients or not.
name | string | The name of the contact.
notes | string | The notes of the contact.
emails | array | An array of all the linked emails
emails.id | integer | The unique ID for the contact email object.
emails.primary | boolean | If the email object is the primary one to the contact.
emails.no_reply | boolean | If the email is a no-reply email address.
emails.address | string | The actual email address for the email object.
phones | array | An array of all the linked phones
phones.id | integer | The unique ID for the contact phone object.
phones.primary | boolean | If the phone object is the primary one to the contact.
phones.number | string | The actual phone number for the phone object.

<a name="index"></a>
## Index

This endpoint indexes all contacts in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/{client_id}/contacts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/contacts/{client_id}/contacts \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": [
        {
            "id": 4903,
            "active": true,
            "for_all_clients": false,
            "name": "Armen Sargsyan",
            "notes": "",
            "emails": [
                {
                    "id": 4346,
                    "primary": true,
                    "no_reply": false,
                    "address": "armen@example.com"
                },
                {
                    "id": 4345,
                    "primary": false,
                    "no_reply": false,
                    "address": "armen@gmail.com"
                }
            ],
            "phones": [
                {
                    "id": 2055,
                    "primary": true,
                    "number": "+43000343422"
                }
            ]
        },
        {
            "id": 4897,
            "active": true,
            "for_all_clients": false,
            "name": "Gregory Peterson",
            "notes": "2",
            "emails": [],
            "phones": [
                {
                    "id": 2051,
                    "primary": true,
                    "number": "+23213123123"
                }
            ]
        },
        {
            "id": 4924,
            "active": true,
            "for_all_clients": false,
            "name": "Antonio Navalny",
            "notes": "",
            "emails": [
                {
                    "id": 4366,
                    "primary": true,
                    "no_reply": false,
                    "address": "antonio@example.com"
                }
            ],
            "phones": []
        }
    ]
}
```

<a name="link"></a>
## Link

This endpoint links a contact to the client.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/contacts/{client_id}/contacts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.
contact_id | integer | **Yes** | The unique ID of the contact.
primary | boolean | **Yes** | Determines if the will be primary or not.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/contacts/{client_id}/contacts \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "contact_id": 3244,
        "primary": true
    }'
```

### Example Response

```http
HTTP/1.1 204 No Content
```

<a name="unlink"></a>
## Unlink

This endpoint unlinks a contact from the client.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/contacts/{client_id}/contacts/{contact_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.
contact_id <small>(url param)</small> | integer | **Yes** | The unique ID of the contact.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/contacts/{client_id}/contacts/{contact_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```



