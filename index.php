<?PHP

//vetor das estações que serão rastreadas
$estacoes = array();

$estacoes[] = ["Id" => 1000887, "Nome" => "Penha"];
$estacoes[] = ["Id" => 504, "Nome" => "Perus"];
//$estacoes[] = ["Id" => 515, "Nome" => "Pirituba"]; //estacao nao retorna todos os dados
$estacoes[] = ["Id" => 509, "Nome" => "Freguesia do Ó"];
$estacoes[] = ["Id" => 510, "Nome" => "Santana/Tucuruvi"];
//$estacoes[] = ["Id" => 1000994, "Nome" => "Tremembé"];//estacao nao retorna todos os dados
//$estacoes[] = ["Id" => 1000862, "Nome" => "São Miguel Paulista"];//estacao nao retorna todos os dados
$estacoes[] = ["Id" => 1000882, "Nome" => "Itaim Paulista"];
//$estacoes[] = ["Id" => 1000884, "Nome" => "São Mateus"];//estacao nao retorna todos os dados
$estacoes[] = ["Id" => 503, "Nome" => "Sé - CGE"];
$estacoes[] = ["Id" => 1000842, "Nome" => "Butantã"];
$estacoes[] = ["Id" => 1000840, "Nome" => "Ipiranga"];
//$estacoes[] = ["Id" => 1000852, "Nome" => "Santo Amaro"];//estacao nao retorna todos os dados
$estacoes[] = ["Id" => 1000850, "Nome" => "M Boi Mirim"];
$estacoes[] = ["Id" => 592, "Nome" => "Cidade Ademar"];
$estacoes[] = ["Id" => 507, "Nome" => "Barragem Parelheiros"];
$estacoes[] = ["Id" => 1000300, "Nome" => "Marsilac"];
$estacoes[] = ["Id" => 1000848, "Nome" => "Lapa"];
$estacoes[] = ["Id" => 1000854, "Nome" => "Campo Limpo"];
//$estacoes[] = ["Id" => 1000857, "Nome" => "Capela do Socorro"];//estacao nao retorna todos os dados
//$estacoes[] = ["Id" => 1000859, "Nome" => "Vila Formosa"];//estacao nao retorna todos os dados
//$estacoes[] = ["Id" => 1000860, "Nome" => "Móoca"];//estacao nao retorna todos os dados
//$estacoes[] = ["Id" => 1000864, "Nome" => "Itaquera"];//estacao nao retorna todos os dados
$estacoes[] = ["Id" => 524, "Nome" => "Vila Prudente"];
$estacoes[] = ["Id" => 495, "Nome" => "Vila Mariana"];
$estacoes[] = ["Id" => 400, "Nome" => "Rio Grande"];
$estacoes[] = ["Id" => 1000876, "Nome" => "Mauá - Paço Municipal"];

//array para retorno final dos dados obtidos
$retorno = array();

//vetores pra converter a data br para en
$pt = ['FEV', 'ABR', 'MAI', 'AGO', 'SET', 'OUT', 'DEZ'];
$en = ['FEB', 'APR', 'May', 'AUG', 'SEP', 'OCT', 'DEC'];


//for para buscar as informações de cada estação
foreach ($estacoes as $value) {
    //id da estacao atual
    $id = $value["Id"];
    //nome da estacao atual
    $nome = $value["Nome"];

    //url para chamada referencia
    $desired_referer = "http://www.saisp.br/";
    //url para pagina que contem os dados da estacao
    $site_z = "https://www.saisp.br/geral/processo_cge.jsp?WHICHCHANNEL=" . $id;

    //variavel para armazenar o html retorno
    global $output;

    //buscar os dados passando o referer, já que o site tem bloquei htaccess e não da pra acessar diretamente o html retorno
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_REFERER, $desired_referer);
    curl_setopt($ch, CURLOPT_URL, $site_z);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);

    //html retoando da pagina
    //echo $output;
    $doc = new DOMDocument();
    $doc->loadHTML($output);

    //busca os valores que estao dentro do tbody
    $nodes = $doc->getElementsByTagName('tbody');
    //print_r($nodes);
    $valores = $nodes[0]->nodeValue;

    //depara os valores pelo \n
    $val = explode("\n", $valores);

    $valores = array();

    //limpa o vetor de valores nulos
    $j = 0;
    foreach ($val as $value) {

        //echo ($j++)." ".$value.'<br/>';
        if ($value != '') {
            $valores[] = $value;
        }
    }

    //exit(0);

    //lista de valores da estacao atual
    $val_ret = array();

    //for para monhtar a linha
    for ($i = 0; $i < count($valores); $i++) {
        $linha = array();


        //converte a data atual para timestamp
        $date = DateTime::createFromFormat('d M Y H:i', str_ireplace($pt, $en, $valores[$i]));

        //em alguns casos esta retornando valores nulos e o vetor fica bagunçado
        //nestes casos seria correto reoordenar o vetor e ignorar os valores nulos
        //como paleativo estou ignorando e pulando estes valores
        if ($date) {
            $linha["timestamp"] = strtotime($date->format('d M Y H:i'));
        } else {
            break;
        }

        $linha["chuva"] = $valores[++$i];
        $linha["vel_vento"] = $valores[++$i];
        $linha["dir_vento"] = $valores[++$i];
        $linha["temp"] = $valores[++$i];
        $linha["umidadade_rel"] = $valores[++$i];
        $linha["pressao"] = $valores[++$i];

        //add a linha na lista de valores
        $val_ret[] = $linha;
    }

    //adiciona os valores no retorno no indice com nome da estacao
    $retorno[$nome] = $val_ret;

}


//retorna o valor em Json
echo json_encode($retorno);
