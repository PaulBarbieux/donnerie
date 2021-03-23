<?php
header('Content-type: application/excel; charset=UTF-8');
header('Content-Disposition: attachment; filename='.$fileName.".xls");
?>
<html xmlns:x="urn:schemas-microsoft-com:office:excel">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!--[if gte mso 9]>
    <xml>
        <x:ExcelWorkbook>
            <x:ExcelWorksheets>
                <x:ExcelWorksheet>
                    <x:Name>Sheet 1</x:Name>
                    <x:WorksheetOptions>
                        <x:Print>
                            <x:ValidPrinterInfo/>
                        </x:Print>
                    </x:WorksheetOptions>
                </x:ExcelWorksheet>
            </x:ExcelWorksheets>
        </x:ExcelWorkbook>
    </xml>
    <![endif]-->
</head>
<body>
<?= $this->fetch('content') ?>
</body></html>