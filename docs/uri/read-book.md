# /read-book

## GET

### Request
        
| Name  | Type  | Description | Default | Required | 
|-------|-------|-------------|---------|----------|          
| id | string |  |  |  Required 

### Response

* object [read_book.json](../schema/read_book.json)

| Name  | Type  | Description | Default | Required | Constrain |
|-------|-------|-------------|---------|----------|-----------| 
| id | string | The unique identifier for a read book. |   |  Optional  |  |
| isbn | string | The unique identifier for a book |   |  Required  | minLength:10, maxLength:13 |
| read_at | string | The date and time that the book was read |   |  Required  | format:datetime |

