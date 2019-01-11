Neste desafio você deverá obter os dados das estações meteorológicas de São Paulo através do site: https://www.cgesp.org/v3/estacoes-meteorologicas.jsp . Seu crawler deverá retornar um objeto JSON contendo os seguintes dados de todas as estações meteorológicas nas últimas 24 horas: timestamp (convertido para epoch), chuva, velocidade do vento, direção do vento, temperatura, umidade relativa e pressão.

Exemplo de resultado esperado do crawler:

{
  "Penha": [
    {
        "timestamp": 1542632400,
        "chuva": 1.2,
        "vel_vento": 3.01,
        "dir_vento": 8,
        "temp": 17.51,
        "umidadade_rel": 86.92,
        "pressao": 934.55
    },
    {
        "timestamp": 1542628800,
        "chuva": 1,
        "vel_vento": 0,
        "dir_vento": 26,
        "temp": 18.04,
        "umidadade_rel": 86.77,
        "pressao": 933.98
    }, 
    ... 
  ],
  "Perus": [
    {
        "timestamp": 1542632400,
        "chuva": 4,
        "vel_vento": 0.19,
        "dir_vento": 136,
        "temp": 18.22,
        "umidadade_rel": 92.31,
        "pressao": 929.58
    },
    {
        "timestamp": 1542628800,
        "chuva": 3.6,
        "vel_vento": 0,
        "dir_vento": 243,
        "temp": 17.84,
        "umidadade_rel": 93.14,
        "pressao": 929.56
    }, 
    ... 
  ],
  ...
}
Perguntas
O que você faria caso quisesse obter essas informações de forma recorrente, ou seja, todo dia?

Como você validaria se as respostas obtidas do crawler estão corretas ou não?

O que você faria se tivesse mais tempo para resolver o desafio?

Como você resolveria esse desafio e/ou as perguntas caso tivesse acesso aos recursos da Amazon Web Services, Azure ou Google Cloud?

Você deverá entregar
Você deverá criar um repositório Git privado no Bitbucket e compartilhá-lo com o usuário big-data-brasil.

Seus códigos a serem avaliados deverão estar contidos na branch master do seu repositório.

Você deverá criar um arquivo Readme.md contendo a documentação do crawler. Neste arquivo deverão estar respondidas as perguntas propostas que poderão ser respondidas separadamente ou em conjunto.

Você será avaliado pela qualidade e efetividade do seu código. Os códigos deverão estar com comentários e bem organizados. Sempre que possível, testes unitários, de integração e linters são bem vindos.
