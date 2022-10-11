# Files

---

- [Index](#index)
- [Upload](#create)
- [View](#view)
- [Update](#update)
- [Delete](#delete)


### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID of the file object.
subtask_id | integer | The unique ID of the subtask which the file is linked to.
client_id | integer |  The unique ID of the client which the file is linked to.
name | string | The full path of the file. Including file name.
original_name | string | The original name of the file.
folder_id | integer |  The unique ID of the folder of the file.

<a name="index"></a>
## Index

This endpoint indexes all files of the client.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/{client_id}/files`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the files are linked to.
page  <small>(url param)</small> | integer | No | Which page of the paginated response we should return.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/clients/{client_id}/files?page=1 \
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
      "subtask_id": null,
      "client_id": 3,
      "name": "client-files/3/FzbkCDL2343D91dl929Adjw3vAd.pdf",
      "original_name": "File example.pdf",
      "folder_id": 2
    },
    {
      "id": 2,
      "subtask_id": null,
      "client_id": 3,
      "name": "client-files/3/FzbkCD23k43D91dlfA9Adjw3vAd.pdf",
      "original_name": "File example 2.pdf",
      "folder_id": 5
    },
    {
      "id": 3,
      "subtask_id": null,
      "client_id": 4,
      "name": "client-files/3/ccASbkCDL2343D91dlfA9Adjw3vAd.pdf",
      "original_name": "File example 3.zip",
      "folder_id": 22
    },
    ...
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/clients/804/files?page=1",
    "last": "https://{environment}.synega.com/api/v3/clients/804/files?page=5",
    "prev": null,
    "next": "https://{environment}.synega.com/api/v3/clients/804/files?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v3/clients/804/files?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "https://{environment}.synega.com/api/v3/clients/804/files?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v3/clients/804/files?page=2",
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "https://{environment}.synega.com/api/v3/clients/804/files",
    "per_page": 10,
    "to": 10,
    "total": 12
  }
}
```

<a name="create"></a>
## Create

This endpoint uploads a base64 encoded file into given folder with given name.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/clients/{client_id}/files`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the file will be linked to.
file | string | **Yes** | The string of the base64 encoded file.
filename | string | **Yes** | The file name including extension.
path | string | **Yes** | The path where the file will be put.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/files \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "file": "JVBERi0xLjQKJcOkw7zDtsOfCjIgMCBvYmoKPDwvTGVuZ3RoIDMgMCBSL0Z..."
        "filename": "exampleFile.pdf",
        "path": "some_of_main_folder/subfolder/more_subfolder",
    }'
```

### Example Response

```http
HTTP/1.1 204 No Content
```

<a name="view"></a>
## View

This endpoint shows a specific file of the client.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/{client_id}/files/{file_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the file is linked to.
file_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client file.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/clients/{client_id}/files/{file_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data":
  {
    "id": 1,
    "subtask_id": null,
    "client_id": 3,
    "name": "client-files/3/FzbkCDL2343D91dl929Adjw3vAd.pdf",
    "original_name": "File example.pdf",
    "folder_id": 2,
    "base64": "UEsDBBQABgAIAAAAIQAykW9XZgEAAKUFAAATAAgCW0NvbnRlbnRfVHlwZXNdLnhtb..."
  },
}
```

<a name="update"></a>
## Update

This endpoint updates a client file. Replaces file, updates a file name or both simultaneously.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/clients/{client_id}/files/{file_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the file is linked to.
file_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client file.
file | string | **Yes** (if no filename provided) | The string of the base64 encoded new file which is supposed to replace the old one.
filename | string | **Yes** (if no file provided) | The file name of the file.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/clients/{client_id}/files/{file_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "file": "JVBERi0xLjQKMSAwIG9iago8PAovVGl0bGUgKP7AFAAcgBpAG...",
       "filename": "New Name.pdf"
    }'
```

### Example Response

```http
HTTP/1.1 204 No Content
```

<a name="delete"></a>
## Delete

This endpoint deletes a specific client file.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v3/clients/{client_id}/files/{file_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the file is linked to.
file_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client file.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v3/clients/{client_id}/files/{file_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```


