
<?php


if (!$_settings->info('license')) {
	exit();
}

$product_id = (isset($_GET['raffle']) ? $_GET['raffle'] : '');
$start_date = (isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-6 days')));
$end_date = (isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'));
echo '<style>' . "\r\n" . '.order_numbers{white-space:normal}tr.text-gray-700.dark\\:text-gray-400{vertical-align:text-bottom}.exportar-contatos{max-width:189px;display:inline-block;margin-bottom:10px}@media all and (max-width:40em){.filtro-busca{display:block!important}}span#approve-payment{background:#2271b1;padding:6px;display:inline-block;margin-top:6px;border-radius:4px;color:#fff;cursor:pointer}td.px-4.py-3.text-sm {max-width: 240px;text-wrap: pretty;}@media only screen and (max-width:600px){.fb-2{margin-top:10px;width:100%}}@media only screen and (max-width:600px){.fb-2{margin-top:10px;width:100%}}' . "\r\n" . '</style>' . "\r\n\r\n" . '<main class="h-full pb-16 overflow-y-auto">' . "\r\n" . '    <div class="container grid px-6 mx-auto">' . "\r\n" . '        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">' . "\r\n" . '        Ranking de compradores' . "\r\n" . '    </h2>  ' . "\r\n\r\n" . '    <form action="" id="filter-form" style="margin-bottom:10px" method="GET">' . "\r\n" . '        <label for="date" class="block text-sm dark:text-gray-300 dark:focus:shadow-outline-gray">Selecione a campanha</label>' . "\r\n" . '        <div class="flex filtro-busca">' . "\r\n" . '            <select name="raffle" id="raffle" class="mr-2 block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">' . "\r\n" . '                <option value="">Selecione</option>' . "\r\n" . '                ';
$qry = $conn->query('SELECT * FROM `product_list`');

while ($row = $qry->fetch_assoc()) {
	echo '              <option value="';
	echo $row['id'];
	echo '" ';

	if ($product_id == $row['id']) {
		echo 'selected';
	}

	echo '>';
	echo $row['name'];
	echo '</option>' . "\r\n" . '               ';
}

echo '            </select>' . "\r\n\r\n" . '            <input name="start_date" id="start_date" type="date" value="';
echo ($start_date ? $start_date : date('Y-m-d', strtotime('-7 days')));
echo '" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">' . "\r\n" . '            <input name="end_date" id="end_date" type="date" value="';
echo ($end_date ? $end_date : date('Y-m-d'));
echo '" class="mr-2 block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">' . "\r\n\r\n" . '            <button class="fb-2 px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple filtrar"> Filtrar</button>' . "\r\n" . '        </div>' . "\r\n" . '    </form>' . "\r\n\r\n" . '    <div class="w-full overflow-hidden rounded-lg shadow-xs">' . "\r\n" . '        <div class="w-full overflow-x-auto">' . "\r\n" . '            




<table class="w-full whitespace-no-wrap">' . "\r\n" . '                <thead>' . "\r\n" . '                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">               ' . "\r\n" . '                    <th class="px-4 py-3">Número</th>' . "\r\n" . '                  ' . "\r\n" . '                    ' . "\r\n" . '                    ' . "\r\n" . '                    <th class="px-4 py-3">Cliente</th><th class="px-4 py-3">Ação</th>' . "\r\n" . '                </tr>' . "\r\n" . '            </thead>' . "\r\n" . '            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">' . "\r\n" . '            ';
$where = '';

if ($product_id) {
	$where .= ' AND o.product_id = \'' . $product_id . '\'';
}
if ($start_date || $end_date) {
	$where .= ' AND o.date_created BETWEEN \'' . $start_date . ' 00:00:00\' AND \'' . $end_date . ' 23:59:59\'';
}

if (!empty($where)) {
	$where = ' WHERE ' . ltrim($where, ' AND');
}

$perPage = 20;
$page = (isset($_GET['pg']) ? $_GET['pg'] : 1);
$offset = $perPage * ($page - 1);
$totalResults = $conn->query('SELECT o.* FROM order_list o ' . $where)->num_rows;
$totalPages = ceil($totalResults / $perPage);
$g_total = 0;
$i = 1;
$requests = $conn->query("\r\n" . '                SELECT c.firstname, c.lastname, c.phone, SUM(o.quantity) AS total_quantity, SUM(o.total_amount) AS total_amount, ' . "\r\n" . '                o.code, CONCAT(\' \', o.product_name) AS product' . "\r\n" . '                FROM order_list o' . "\r\n" . '                INNER JOIN customer_list c ON o.customer_id = c.id' . "\r\n" . '                ' . $where . ' AND o.status = 2' . "\r\n" . '                GROUP BY o.customer_id' . "\r\n" . '                ORDER BY total_quantity DESC' . "\r\n" . '                LIMIT ' . $perPage . ' OFFSET ' . $offset . "\r\n" . '                ');



function maskPhoneNumber($phone) {
    // Remove non-numeric characters
    $phone = preg_replace('/\D/', '', $phone);

    // Check if the phone number length is valid
    if (strlen($phone) === 11) {
        // Format the phone number
        $formatted = '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 5) . '-' . substr($phone, 7, 4);
        // Mask the last four digits
        $masked = substr($formatted, 0, -4) . 'xxxx';
        return $masked;
    }

    // Return the phone number without formatting if length is unexpected
    return $phone;
}
$i = 1;  // Inicializar o contador fora do loop

while ($row = $requests->fetch_assoc()) {
    echo '<tr class="text-gray-700 dark:text-gray-400">' . "\r\n";
    
    // Adicionar a coluna para a numeração
    echo '    <td class="px-4 py-3" style="color: purple; font-weight: bold; font-size: 24px; text-align: center; vertical-align: middle;">';
    echo $i;
    echo '</td>' . "\r\n";
    
    // Adicionar as informações do cliente
    echo '    <td class="px-4 py-3">';
    echo $row['firstname'] . ' ' . $row['lastname'] . '<br>';
    echo '<span style="font-family: \'CustomFont\', sans-serif; font-size: 14px;">'; // Fonte personalizada e tamanho menor
    // Chama a função para formatar e mascarar o número de telefone
    echo maskPhoneNumber($row['phone']) . '<br>';
    echo 'Qtd. Cotas ' . $row['total_quantity'] . ' / Total: R$ ' . format_num($row['total_amount'], 2);
    echo '</span>';
    echo '</td>' . "\r\n";
    
    // Adicionar a coluna do ícone do WhatsApp
    echo '    <td class="px-4 py-3" style="vertical-align: middle; padding-left: 5px;">';
    $whatsappLink = 'https://wa.me/' . preg_replace('/\D/', '', $row['phone']);
    echo '<a href="' . $whatsappLink . '" target="_blank">';
    echo '<i class=" " style="font-size:22px; 
     margin-block:auto;
    "><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="green" class="bi bi-whatsapp" viewBox="0 0 16 16"> <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"></path></svg></i>';
    echo '</a>';
    echo '</td>' . "\r\n";
    
    echo '</tr>' . "\r\n";
    
    $i++;  // Incrementar o contador
}




echo '        </tbody>' . "\r\n\r\n" . '    </table>' . "\r\n\r\n" . '</div>' . "\r\n" . '<div' . "\r\n" . 'class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"' . "\r\n" . '>' . "\r\n" . '<span class="flex items-center col-span-3">' . "\r\n" . '</span>' . "\r\n" . '<span class="col-span-2"></span>' . "\r\n\r\n" . '<!-- Pagination -->' . "\r\n";

if (0 < $totalPages) {
	echo '    <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">' . "\r\n" . '        <nav aria-label="Table navigation">' . "\r\n" . '            <ul class="inline-flex items-center">' . "\r\n\r\n" . '                ';

	if (1 < $page) {
		echo '                    <a href=\'./?page=ranking&pg=';
		echo $page - 1;
		echo '\'><li>' . "\r\n" . '                        <button' . "\r\n" . '                        class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"' . "\r\n" . '                        aria-label="Previous"' . "\r\n" . '                        >' . "\r\n" . '                        <svg' . "\r\n" . '                        class="w-4 h-4 fill-current"' . "\r\n" . '                        aria-hidden="true"' . "\r\n" . '                        viewBox="0 0 20 20"' . "\r\n" . '                        >' . "\r\n" . '                        <path' . "\r\n" . '                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"' . "\r\n" . '                        clip-rule="evenodd"' . "\r\n" . '                        fill-rule="evenodd"' . "\r\n" . '                        ></path>' . "\r\n" . '                    </svg>' . "\r\n" . '                </button>' . "\r\n" . '            </li></a>' . "\r\n" . '        ';
	}

	echo "\r\n" . '        ';

	if (3 < $page) {
		echo '            <a href="./?page=ranking&raffle=';
		echo $product_id;
		echo '&start_date=';
		echo $start_date;
		echo '&end_date=';
		echo $end_date;
		echo '&pg=1"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">1</button></li></a>' . "\r\n" . '            <li class="dots">...</li>' . "\r\n" . '        ';
	}

	echo "\r\n" . '        ';

	if (0 < ($page - 2)) {
		echo '            <a href="./?page=ranking&raffle=';
		echo $product_id;
		echo '&start_date=';
		echo $start_date;
		echo '&end_date=';
		echo $end_date;
		echo '&pg=';
		echo $page - 2;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $page - 2;
		echo '</button></li></a>' . "\r\n" . '        ';
	}

	echo "\r\n" . '        ';

	if (0 < ($page - 1)) {
		echo '            <a href="./?page=ranking&raffle=';
		echo $product_id;
		echo '&start_date=';
		echo $start_date;
		echo '&end_date=';
		echo $end_date;
		echo '&pg=';
		echo $page - 1;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $page - 1;
		echo '</button></li></a>' . "\r\n" . '        ';
	}

	echo "\r\n" . '        <a href="./?page=ranking&raffle=';
	echo $product_id;
	echo '&start_date=';
	echo $start_date;
	echo '&end_date=';
	echo $end_date;
	echo '&pg=';
	echo $page;
	echo '">' . "\r\n" . '            <li>' . "\r\n" . '                <button class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple">';
	echo $page;
	echo '</button>' . "\r\n" . '            </li>' . "\r\n" . '        </a>' . "\r\n" . '        ';

	if (($page + 1) < ($totalPages + 1)) {
		echo '            <a href="./?page=ranking&raffle=';
		echo $product_id;
		echo '&start_date=';
		echo $start_date;
		echo '&end_date=';
		echo $end_date;
		echo '&pg=';
		echo $page + 1;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $page + 1;
		echo '</button></li></a>   ' . "\r\n" . '        ';
	}

	echo "\r\n" . '        ';

	if (($page + 2) < ($totalPages + 1)) {
		echo '            <a href="./?page=ranking&raffle=';
		echo $product_id;
		echo '&start_date=';
		echo $start_date;
		echo '&end_date=';
		echo $end_date;
		echo '&pg=';
		echo $page + 2;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $page + 2;
		echo '</button></li></a>' . "\r\n" . '        ';
	}

	echo "\r\n" . '        ';

	if ($page < ($totalPages - 2)) {
		echo '            <li class="dots">...</li>' . "\r\n" . '            <a href="./?page=ranking&raffle=';
		echo $product_id;
		echo '&start_date=';
		echo $start_date;
		echo '&end_date=';
		echo $end_date;
		echo '&pg=';
		echo $totalPages;
		echo '"><li><button class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple">';
		echo $totalPages;
		echo '</button></li></a>' . "\r\n" . '        ';
	}

	echo "\r\n\r\n" . '        ';

	if ($page < $totalPages) {
		echo '            ' . "\r\n" . '            <a href="./?page=ranking&raffle=';
		echo $product_id;
		echo '&start_date=';
		echo $start_date;
		echo '&end_date=';
		echo $end_date;
		echo '&pg=';
		echo $page + 1;
		echo '"><li>' . "\r\n" . '                <button' . "\r\n" . '                class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"' . "\r\n" . '                aria-label="Next"' . "\r\n" . '                >' . "\r\n" . '                <svg' . "\r\n" . '                class="w-4 h-4 fill-current"' . "\r\n" . '                aria-hidden="true"' . "\r\n" . '                viewBox="0 0 20 20"' . "\r\n" . '                >' . "\r\n" . '                <path' . "\r\n" . '                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"' . "\r\n" . '                clip-rule="evenodd"' . "\r\n" . '                fill-rule="evenodd"' . "\r\n" . '                ></path>' . "\r\n" . '            </svg>' . "\r\n" . '        </button>' . "\r\n" . '    </li>' . "\r\n" . '</a>' . "\r\n";
	}

	echo "\r\n" . '</ul>' . "\r\n" . '</nav>' . "\r\n" . '</span>' . "\r\n" . '<!-- End pagination -->' . "\r\n";
}

echo "\r\n" . '</div>' . "\r\n" . '</div>' . "\r\n" . '</div>' . "\r\n" . '</main>' . "\r\n\r\n" . '<script>' . "\r\n" . '    $(function(){' . "\r\n" . '        $(\'#filter-form\').submit(function(e){' . "\r\n" . '            e.preventDefault()' . "\r\n" . '            location.href = \'./?page=ranking&\'+$(this).serialize()' . "\r\n" . '        })' . "\r\n\r\n\r\n" . '    })' . "\r\n" . '</script>';

?>

