# Folders

---

- [Index](#index)
- [View](#view)
- [Delete](#delete)


### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID of the folder object.
parent_id | integer | The unique ID of the parent folder which the folder is located in.
client_id | integer |  The unique ID of the client which the folder is linked to.
name | string | The name of the folder.
subfolders | object | The object of the subfolders of the folder.
files | object | The object of the files located in the folder.

<a name="index"></a>
## Index

This endpoint indexes all folders of the client.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/{client_id}/folders`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the folders are linked to.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/clients/{client_id}/folders \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "parent_id": 0,
      "client_id": 0,
      "name": "Faste opplysninger",
      "subfolders": [
        {
          "id": 2,
          "parent_id": 1,
          "client_id": 0,
          "name": "Oppdragsavtale",
          "subfolders": [],
          "files": []
        },
        {
          "id": 6,
          "parent_id": 1,
          "client_id": 0,
          "name": "Innhenting av uttalelse om nytt oppdrag",
          "subfolders": [
            {
              "id": 35003,
              "parent_id": 6,
              "client_id": 0,
              "name": "I like it",
              "subfolders": [],
              "files": []
            }
          ],
          "files": [
            {
              "id": 100,
              "subtask_id": null,
              "client_id": 200,
              "name": "client-files/802/GA1YWZD4rpwFXRl7ZG2PmpYQTepone6opJYHdDb9.docx",
              "original_name": "file 1.docx",
              "folder_id": 6
            },
            {
              "id": 101,
              "subtask_id": null,
              "client_id": 200,
              "name": "client-files/802/X51Voa09BxE1CPuYEXH6iDTaLFJjMRUOGC3xyBvy.docx",
              "original_name": "file 2.docx",
              "folder_id": 6
            }
          ]
        }
      ],
      "files": []
    }
  ]
}
```

<a name="view"></a>
## View

This endpoint shows a specific folder of the client.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/{client_id}/folders/{folder_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the folder is linked to.
folder_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client folder.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/clients/{client_id}/folders/{folder_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 6,
    "parent_id": 1,
    "client_id": 0,
    "name": "Innhenting av uttalelse om nytt oppdrag",
    "subfolders": [
      {
        "id": 12,
        "parent_id": 6,
        "client_id": 0,
        "name": "Subfolder Level 1",
        "subfolders": [
          {
            "id": 20,
            "parent_id": 12,
            "client_id": 0,
            "name": "Subfolder Level 1-1",
            "subfolders": [],
            "files": []
          }
        ],
        "files": []
      }
    ],
    "files": []
  }
}
```

<a name="delete"></a>
## Delete

This endpoint deletes a specific client folder.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/clients/{client_id}/folders/{folder_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the folder is linked to.
folder_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client folder.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/clients/{client_id}/folders/{folder_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```


