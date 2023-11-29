<?php 

$entityBody = file_get_contents('php://input');

$data = convertXmlToArray($entityBody);

switch ($data['REQ']['OPT'] ) {
    case 1: //Пополнение карты
                echo "<ASW>
                <OPT>".$data['REQ']['OPT']."</OPT>
                <PAN>".$data['REQ']['PAN']."</PAN>
                <AMOUNT>".$data['REQ']['AMOUNT']."</AMOUNT>
                <STAN>".$data['REQ']['STAN']."</STAN>
                <DATE>".$data['REQ']['DATE']."</DATE>
                <NTERM>".$data['REQ']['NTERM']."</NTERM>
                <FEE>0</FEE>
                <CURR>971</CURR>
                <C_MAX>000001499877</C_MAX>
                <RREF>232013574855</RREF>       
                <AUTH>X2DRMT</AUTH>           
                <ERRC>00</ERRC>                 
                <C_FEE>100</C_FEE>             
            </ASW>
            ";
        break;
    case 2: //Оплата с карты
                echo "<ASW>
                <OPT>".$data['REQ']['OPT']."</OPT>
                <PAN>".$data['REQ']['PAN']."</PAN>
                <AMOUNT>".$data['REQ']['AMOUNT']."</AMOUNT>
                <STAN>".$data['REQ']['STAN']."</STAN>
                <DATE>".$data['REQ']['DATE']."</DATE>
                <NTERM>".$data['REQ']['NTERM']."</NTERM>
                <CURR>810</CURR>
                <EXP>1309</EXP>
                <RREF>232013574869</RREF>
                <AUTH>S2PR0T</AUTH>
                <ERRC>00</ERRC>
           </ASW>
            ";
        break;
    case 3: //Подтверждение операции
                echo "<ASW>
                 <OPT>".$data['REQ']['OPT']."</OPT>
                 <STAN>".$data['REQ']['STAN']."</STAN>
                 <DATE>".$data['REQ']['DATE']."</DATE>
                 <NTERM>".$data['REQ']['NTERM']."</NTERM>
                 <RREF>232013574869</RREF>
                 <AUTH>AU1234</AUTH>    		
                 <C_RREF>232013574800</C_RREF>
                 <C_AUTH>AU2345</C_AUTH>    	
                 <ERRC>00</ERRC>
            </ASW>
            ";
        break;
    case 4: //Отмена операции
        echo "<ASW>
               <OPT>".$data['REQ']['OPT']."</OPT>
                 <PAN>643110000002222</PAN>
                 <AMOUNT>1500</AMOUNT>
                 <STAN>".$data['REQ']['STAN']."</STAN>
                 <DATE>".$data['REQ']['DATE']."</DATE>
                 <NTERM>".$data['REQ']['NTERM']."</NTERM>
                 <CURR>810</CURR>
                 <RREF>981115000003</RREF>
                 <ERRC>76</ERRC> 
                 <ERRT>485 Не найдена оригинальная операция</ERRT> 
            </ASW>
            ";
        break;
    case 5: //CARD2CARD
        echo "<ASW>
               <OPT>".$data['REQ']['OPT']."</OPT>
                 <PAN>".$data['REQ']['PAN']."</PAN>
                 <AMOUNT>".$data['REQ']['AMOUNT']."</AMOUNT>
                 <STAN>".$data['REQ']['STAN']."</STAN>
                 <DATE>".$data['REQ']['DATE']."</DATE>
                 <NTERM>".$data['REQ']['NTERM']."</NTERM>
                 <FEE>0</FEE>
                 <CURR>810</CURR>
                 <C_PAN>".$data['REQ']['C_PAN']."</C_PAN>
                 <EXP>".$data['REQ']['EXP']."</EXP>
                 <RREF>232013574800</RREF>
                 <AUTH>AU2345</AUTH>    
                 <C_AMT>121</C_AMT>    
                 <C_FEE>100</C_FEE>    
                 <C_RREF>232013574800</C_RREF>
                 <C_AUTH>AU2345</C_AUTH>    
                 <C_TEXT>Комиссия 2,5% не менее 1р и не более 100р</C_TEXT> 
                 <COMMENT>perevod na card 79000000000</COMMENT> 
                 <C_COMMENT>perevod s card 79220167706</C_COMMENT> 
                 <CARDTYPE>C1</CARDTYPE> 
                 <C_MAX>000001376770</C_MAX> 
                 <ERRC>00</ERRC> 
                 <P39>000</P39> 
                 <CARDPROG>RXPY</CARDPROG> 
            </ASW>
            ";
        break;
    case 6: //Возврат
        echo "<ASW>
               <OPT>".$data['REQ']['OPT']."</OPT>
                 <PAN>".$data['REQ']['PAN']."</PAN>
                 <AMOUNT>".$data['REQ']['AMOUNT']."</AMOUNT>
                 <STAN>".$data['REQ']['STAN']."</STAN>
                 <DATE>".$data['REQ']['DATE']."</DATE>
                 <NTERM>".$data['REQ']['NTERM']."</NTERM>
                 <RREF>232013574800</RREF>
                 <AUTH>AU2345</AUTH>    
                 <CURR>810</CURR>
                 <CARDPROG>RXPY</CARDPROG> 
                 <ERRC>00</ERRC> 
            </ASW>
            ";
        break;
    case 7: //Запрос остатка
        echo "<ASW>
                 <OPT>".$data['REQ']['OPT']."</OPT>
                 <PAN>".$data['REQ']['PAN']."</PAN>
                 <AMOUNT>1250</AMOUNT>
                 <STAN>".$data['REQ']['STAN']."</STAN>
                 <DATE>".$data['REQ']['DATE']."</DATE>
                 <NTERM>".$data['REQ']['NTERM']."</NTERM>
                 <RREF>232013574800</RREF>
                 <AUTH>AU2345</AUTH>    
                 <CURR>810</CURR>
                 <CARDPROG>RXPY</CARDPROG> 
                 <ERRC>00</ERRC> 
            </ASW>
            ";
        break;
    case 8: //Блокировка карты
        echo "<ASW>
                 <OPT>".$data['REQ']['OPT']."</OPT>
                 <PAN>".$data['REQ']['PAN']."</PAN>
                 <STAN>".$data['REQ']['STAN']."</STAN>
                 <DATE>".$data['REQ']['DATE']."</DATE>
                 <NTERM>".$data['REQ']['NTERM']."</NTERM>
                 <RREF>232013574800</RREF>
                 <ERRC>00</ERRC> 
                 <ERRT>0</ERRT> 
            </ASW>
            ";
        break;
        case 9: //Минивыписка
        echo "<ASW>
                <OPT>9</OPT>
                <PAN>4406904450369017</PAN>
                <STAN>133</STAN>
                <DATE>121115102233</DATE>
                <NTERM>100383</NTERM>
                <RREF>232015574922</RREF>
                <ERRC>00</ERRC>
                <MSTAT>
                    <REC>
                        <DATE>130102</DATE>
                        <CURR>643</CURR>
                        <AMT>1500000</AMT>
                        <TYPE>C</TYPE>
                    </REC>
                    <REC>
                        <DATE>750223</DATE>
                        <CURR>643</CURR>
                        <AMT>362</AMT>
                        <TYPE>D</TYPE>
                    </REC>
                </MSTAT>
            </ASW>
            ";
        break;
}


function convertXmlToArray($data)
{
    $content = mb_convert_encoding($data, "utf-8", "windows-1251");;

    $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA, '', true);

    $json = json_encode($xml);
    $dataArray[$xml->getName()] = json_decode($json, TRUE);

    return $dataArray;

}

?>