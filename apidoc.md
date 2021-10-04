# API Aluguer de Automóveis
Documentação da API - Descrição
## Endpoints
### GET /api/v1/marca
Lista de todas as marcas
#### Parameters
filtro=atributo,:operador:,valor;[atributo,:operador:,valor]
atributo=atributo1[,atributo2,atributon]
#### Responses
##### 200 OK!
Response example:
```
[
    {
        "id": 3,
        "nome": "Tesla",
        "imagem": "eletrico.png",
        "created_at": "2021-09-26T18:16:33.000000Z",
        "updated_at": "2021-09-26T21:03:44.000000Z",
        "modelos": []
    },
    {
        "id": 4,
        "nome": "Peugeot",
        "imagem": "peugeott.jpgee",
        "created_at": "2021-09-26T19:43:47.000000Z",
        "updated_at": "2021-09-26T21:03:14.000000Z",
        "modelos": [
            {
                "id": 2,
                "marca_id": 4,
                "nome": "5008",
                "imagem": "imagens/modelos/lJeW00iIKxUtQEL0POcu5DI0ZQUsJ9RO7DRF5fje.jpg",
                "numero_portas": 5,
                "lugares": 5,
                "air_bag": 1,
                "abs": 1,
                "created_at": "2021-09-28T16:24:17.000000Z",
                "updated_at": "2021-09-28T21:36:55.000000Z"
            }
        ]
    },
    {
        "id": 5,
        "nome": "Teslaa",
        "imagem": "imagens/bbLDCkZ9x0wYDrb1ENcPxpVYc3xSLO2g4aR7ykW2.jpg",
        "created_at": "2021-09-26T21:04:48.000000Z",
        "updated_at": "2021-09-28T21:33:06.000000Z",
        "modelos": []
    }
]
```
##### 401 Authentication failure!
Response example:
```
{
    "message": "The token has been blacklisted",
```
E continuar para cada endpoit

