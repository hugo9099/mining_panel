<?php
/**
 * Created by PhpStorm.
 * User: hm909
 * Date: 1/16/17
 * Time: 17:37
 */


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    //echo $id;

} else {
    echo "Please give an ID";
    $id = '';
}


function data_post($url)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $pb_result = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //   doLog(print_r($transaction_id, true));
    curl_close($ch);
    $pb_result2 = $code . $pb_result;

    return $pb_result;

}


$myurl = 'http://' . $id . '.ethosdistro.com/?json=yes';
$text_response = data_post($myurl);
$json_data = json_decode($text_response, true);

//var_dump($json_data);

//echo array_keys($json_data);


//echo $text_response;
//echo $text_response;


//echo array_keys($json_data['rigs']);

//var_dump($json_data['per_info']);






?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>42641a ethOS</title>
    <link href="assets/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/tablecloth.css" rel="stylesheet">
    <link href="assets/css/prettify.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="favicon.png">
    <style>td {
            white-space: nowrap;
            word-spacing: -0.5px;
            letter-spacing: -0.2px
        }

        .hasTooltip span {
            display: none;
            color: #000;
            text-decoration: none;
            padding-left: 5px;
            padding-right: 5px;
        }

        .hasTooltip:hover span {
            display: block;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-top: 10px;
        }

        body {
            background-image: url("background.png");
        }
    </style>


    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.metadata.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.4/js/jquery.tablesorter.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.4/js/parsers/parser-network.min.js"></script>
    <script src="assets/js/jquery.tablecloth.js"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $("table").tablecloth({
                theme: "stats",
                striped: true,
                sortable: true,
                condensed: true
            });
        });
    </script>


</head>
<body>
<div class="container" style="width: 99%">
    <div class="row" style="width: 100%">
        <div class="span12" style="width: 100%">
            <table cellspacing="1" cellpadding="3" class="tablehead"
                   style="background:#CCC; width:100%; margin-bottom: 0px;">
                <caption>
                    <div>
                        <div style="float:left">
                            <table style="width: 300px; margin-bottom:0px;">
                                <tr>
                                    <td><?php echo $json_data['alive_gpus'] . '/' . $json_data['total_gpus']; ?> GPUs
                                        (<?php echo $json_data['capacity']; ?>%)
                                    </td>
                                    <td>
                                        <a href="http://ethosdistro.com/graphs/global.php?panel=<?php echo $id; ?>&type=avg_temp">
                                            <div
                                                style="color: hsl(220.21, 100%, 30%);; display:inline"><?php echo $json_data['avg_temp']; ?></div>
                                            average temp in C</a></td>
                                    <td><?php $t = time();
                                        echo date(DATE_RFC822); ?></td>
                                    <td><a href="http://mining.gpushack.com/">gpuShack</a> &middot; <a
                                            href="http://ethosdistro.com/kb/">Support</a> &middot; <a
                                            href="http://ethosdistro.com/">ethOS</a> &middot; <a
                                            href="http://ethereum-mining-calculator.com/?ref=ethos">Mining
                                            Calculator</a></td>

                                </tr>
                                <tr>
                                    <td><?php echo $json_data['alive_rigs'] . '/' . $json_data['total_rigs']; ?> rigs</td>

                                    <td><a class="hasTooltip"
                                           href="http://ethosdistro.com/graphs/global.php?panel=<?php echo $id; ?>&type=all_hash"><?php echo $json_data['total_hash']; ?>
                                            total hash<span><br/><table><tr>
			<td><b>miner</b></td>
			<td><b>hash</b></td>
			<td><b>up GPUs</b></td>
			<td><b>GPUs</b></td>
                        <td><b>up rigs</b></td>
                        <td><b>rigs</b></td>
			<td><b>hash/GPU</b></td>
			<td><b>hash/rig</b></td>

		</tr>






                                                 <?php


                                                 foreach ($json_data['per_info'] as $key => $value) {
                                                     
    echo '
    <tr>
            <td>'.$key.'</td>
            <td align="right">'.$value['hash'].'</td>
            <td align="right">'.$value['per_alive_gpus'].'</td>
            <td align="right">'.$value['per_total_gpus'].'</td>
            <td align="right">'.$value['per_alive_rigs'].'</td>
            <td align="right">'.$value['per_total_rigs'].'</td>
            <td align="right">'.$value['per_hash-gpu'].'</td>
            <td align="right">'.$value['per_hash-rig'].'</td>
        </tr>
    ';
}
?>
                     </table></span></a></td>
                                    <td>Latest Version: <?php echo $json_data['current_version']; ?></td>
                                    <td><a href="http://<?php echo $id; ?>.ethosdistro.com/?json=yes">API</a> &middot; <a
                                            href="http://<?php echo $id; ?>.ethosdistro.com/?ailments=mining">Ailments</a> &middot;
                                        <a href="http://<?php echo $id; ?>.ethosdistro.com/?search=192.168">IP Search</a> &middot;
                                        <a href="http://ethosdistro.com/globalstats/<?php echo $id; ?>.ips.txt">IPs</a> &middot; <a
                                            href="http://<?php echo $id; ?>.ethosdistro.com/?bios=yes">GPU bioses</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div>
                    </div>
                </caption>
                <thead>
                <tr class="colhead">
                    <th align="left" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">V<span>ethOS version and running miner</span></a>
                    </th>
                    <th align="left" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">M<span>current running miner</span></a>
                    </th>
                    <th align="left" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">G<span>live GPUs / detected GPUs, hover to get GPU model names</span></a>
                    </th>
                    <th align="left" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">name<span>rig name, conditions and events appear in column, hover over for more info</span></a>
                    </th>
                    <th align="left" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">loc<span>location of rig, check ethosdistro.com/pool.txt for sample config</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">rig
                            admin<span>rig IP address and admin terminal, green = fglrx, blue = amdgpu</span></a></th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">p<span>elapsed time since rig lasted pinged your stats panel (last reachable)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">b<span>elapsed time since rig booted (rig uptime)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">m<span>elapsed time since miner has started (running miner)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">rx<span>10 minute average of kbps received by rig (may indicate rig compromise if value is very high and rig port is open)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">tx<span>10 minute average of kbps send by rig (may indicate rig compromise if value is very high and rig port is open)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">L<span>5 minute load average (sysload)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">C<span>cpu temperature (in C)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">R<span>amount of system ram (in gigabytes)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">F<span>total free space (in gigabytes)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">H<span>total hashrate, hover over to see local pool info, hash color will be odd if pool info is different</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">hashes<span>hashrate per GPU (available in ethOS 1.0.7+)</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">temps<span>temperature of GPUs (in C), click on temps to see historical data</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">ptune<span>gpu powertune values (in percents), hover to see gpu voltages</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">fans<span>GPU fan rpms (in K-rpm), click on fan rpms to see historical data, hover to see percents</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">core<span>gpu core clocks (in ghz), hover to get default GPU core clocks</span></a>
                    </th>
                    <th align="right" class="headerSortable" style="font-weight: normal"><a href="#" class="hasTooltip">mem<span>gpu memory clocks (in ghz), hover to get default GPU mem clocks</span></a>
                    </th>
                </tr>
                </thead>












                <td align="left">1.1.8</td>
                <td align="left"><a class="hasTooltip">
                        <div style="display: inline; color: hsl(185, 89%, 23%)">sg-x</div>
                        <span>sgminer-gm-xmr 5.5.4-gm</span></a></td>
                <td align="left"><a href="#" class="hasTooltip" style="color:black">
                        <div style=" display:inline; color: hsl(100, 100%, 25%);">6/6</div>
                        <span>8gb &middot; 01 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 02 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 05 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 06 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 09 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 0a ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb</span></a></td>
                <td align="left">
                    <div style="display:inline; font-family: monospace;">
                        <a href="#" class="hasTooltip"
                           style="color: hsl(34, 89%, 22%); text-decoration: none">0a0ec8<span>4044.4 hash: miner active<br/>990FXA-UD3 R5<br/>KingDian S200 60GB 2016101700036<br/>Realtek Semiconductor Co., Ltd. RTL8111/8168/8411 PCI Express Gigabit Ethernet Controller (rev 0c)<br/>4.8.0-rc6-ethos3<br/>AMD FX(tm)-4300 Quad-Core Processor<br/>
AMD FX(tm)-4300 Quad-Core Processor<br/>
AMD FX(tm)-4300 Quad-Core Processor<br/>
AMD FX(tm)-4300 Quad-Core Processor</span></div>
                </td>
                <td align="left"></td>
                <td align="right"><a target=_blank href="http://192.168.0.17/"><span
                            style="color: #006; text-decoration: underline" class="ip_address">192.168.0.17</span></a>
                </td>
                <td align="right"><a class="hasTooltip">
                        <div style="display: inline; color: #00a">s18</div>
                        <span>Jan 16 2017 22:36:05 UTC<br/>0 days, 0 hours, 0 mins, 18 sec</span></a></td>
                <td align="right"><a class="hasTooltip">
                        <div style="display: inline; color: #090">h7</div>
                        <span>Jan 16 2017 14:51:34 UTC<br/>0 days, 7 hours, 44 mins, 49 sec</span></a></td>
                <td align="right"></td>
                <td align="right"><a href="/graphs/?rig=0a0ec8&type=rx_kbps"><span style="color: hsl(253, 100%, 30%);">0.0</span></a>
                </td>
                <td align="right"><a href="/graphs/?rig=0a0ec8&type=tx_kbps"><span style="color: hsl(252, 100%, 30%);">0.1</span></a>
                </td>
                <td align="right"><a href="/graphs/?rig=0a0ec8&type=load"><span
                            style="color: hsl(219, 100%, 30%);">0.3</span></a></td>
                <td align="right"><a href="/graphs/?rig=0a0ec8&type=cpu_temp"><span style="color: hsl(286, 100%, 30%);">14</span></a>
                </td>
                <td align="right">4</td>
                <td align="right"><span style="color: hsl(255, 100%, 30%);">10</span></td>
                <td align="right"><a href="/graphs/?rig=0a0ec8&type=hash" class="hasTooltip"
                                     style="color: hsl(162, 92%, 24%) ">4044<span>stratumproxy enabled<br/>
proxywallet ...82<br/>
proxypool1 pool.minexmr.com:7777<br/>
proxypool2 pool.minexmr.com:5555<br/>
</span></a></td>
                <td align="right"><a class="hasTooltip" align="left" href="/graphs/?rig=0a0ec8&type=miner_hashes">
                        <div style="color: hsl(224, 100%, 25%);; display:inline">672</div>
                        <div style="color: hsl(224, 100%, 25%);; display:inline">673</div>
                        <div style="color: hsl(225, 100%, 25%);; display:inline">676</div>
                        <div style="color: hsl(225, 100%, 25%);; display:inline">676</div>
                        <div style="color: hsl(225, 100%, 25%);; display:inline">675</div>
                        <div style="color: hsl(223, 100%, 25%);; display:inline">672</div>
                        <br/><span><div style="color: hsl(224, 100%, 25%);; display:inline">672.10</div> <div
                                style="color: hsl(224, 100%, 25%);; display:inline">673.10</div> <div
                                style="color: hsl(225, 100%, 25%);; display:inline">676.20</div> <div
                                style="color: hsl(225, 100%, 25%);; display:inline">676.10</div> <div
                                style="color: hsl(225, 100%, 25%);; display:inline">675.40</div> <div
                                style="color: hsl(223, 100%, 25%);; display:inline">671.50</div><br/> ( UTC)</span></a>
                </td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=0a0ec8&type=temp">
                        <div style="color: hsl(227, 100%, 30%);; display:inline">45</div>
                        <div style="color: hsl(227, 100%, 30%);; display:inline">45</div>
                        <div style="color: hsl(215, 100%, 30%);; display:inline">47</div>
                        <div style="color: hsl(198, 100%, 30%);; display:inline">50</div>
                        <div style="color: hsl(198, 100%, 30%);; display:inline">50</div>
                        <div style="color: hsl(221, 100%, 30%);; display:inline">46</div>
                        <span align="left"><div style="color: #000; display:inline">00</div>  ( UTC)</span></a></td>
                <td align="right"><a href="#" class="hasTooltip">
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <span>n/a</span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=0a0ec8&type=fanrpm">
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <span>percents: 84 84 84 84 84 84<br/>k-rpms: <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> </span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=0a0ec8&type=core">
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <span><div style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> </span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=0a0ec8&type=mem">
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <span><div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> </span></a></td>
                </tr>
                <td align="left">1.1.8</td>
                <td align="left"><a class="hasTooltip">
                        <div style="display: inline; color: hsl(185, 89%, 23%)">sg-x</div>
                        <span>sgminer-gm-xmr 5.5.4-gm</span></a></td>
                <td align="left"><a href="#" class="hasTooltip" style="color:black">
                        <div style=" display:inline; color: hsl(100, 100%, 25%);">6/6</div>
                        <span>8gb &middot; 01 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 02 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 05 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 06 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 09 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 0a ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb</span></a></td>
                <td align="left">
                    <div style="display:inline; font-family: monospace;">
                        <a href="#" class="hasTooltip"
                           style="color: hsl(34, 89%, 22%); text-decoration: none">0bc6e4<span>4050.7 hash: miner active<br/>990FXA-UD3 R5<br/>KingDian S200 60GB 2016101700297<br/>Realtek Semiconductor Co., Ltd. RTL8111/8168/8411 PCI Express Gigabit Ethernet Controller (rev 0c)<br/>4.8.0-rc6-ethos3<br/>AMD FX(tm)-4300 Quad-Core Processor<br/>
AMD FX(tm)-4300 Quad-Core Processor<br/>
AMD FX(tm)-4300 Quad-Core Processor<br/>
AMD FX(tm)-4300 Quad-Core Processor</span></div>
                </td>
                <td align="left"></td>
                <td align="right"><a target=_blank href="http://192.168.0.24/"><span
                            style="color: #006; text-decoration: underline" class="ip_address">192.168.0.24</span></a>
                </td>
                <td align="right"><a class="hasTooltip">
                        <div style="display: inline; color: #00a">s86</div>
                        <span>Jan 16 2017 22:34:57 UTC<br/>0 days, 0 hours, 1 mins, 26 sec</span></a></td>
                <td align="right"><a class="hasTooltip">
                        <div style="display: inline; color: #c60">m27</div>
                        <span>Jan 16 2017 22:09:30 UTC<br/>0 days, 0 hours, 26 mins, 53 sec</span></a></td>
                <td align="right"></td>
                <td align="right"><a href="/graphs/?rig=0bc6e4&type=rx_kbps"><span style="color: hsl(253, 100%, 30%);">0.0</span></a>
                </td>
                <td align="right"><a href="/graphs/?rig=0bc6e4&type=tx_kbps"><span style="color: hsl(252, 100%, 30%);">0.1</span></a>
                </td>
                <td align="right"><a href="/graphs/?rig=0bc6e4&type=load"><span
                            style="color: hsl(222, 100%, 30%);">0.3</span></a></td>
                <td align="right"><a href="/graphs/?rig=0bc6e4&type=cpu_temp"><span style="color: hsl(286, 100%, 30%);">14</span></a>
                </td>
                <td align="right">4</td>
                <td align="right"><span style="color: hsl(255, 100%, 30%);">10</span></td>
                <td align="right"><a href="/graphs/?rig=0bc6e4&type=hash" class="hasTooltip"
                                     style="color: hsl(162, 92%, 24%) ">4051<span>stratumproxy enabled<br/>
proxywallet ...82<br/>
proxypool1 pool.minexmr.com:7777<br/>
proxypool2 pool.minexmr.com:5555<br/>
</span></a></td>
                <td align="right"><a class="hasTooltip" align="left" href="/graphs/?rig=0bc6e4&type=miner_hashes">
                        <div style="color: hsl(225, 100%, 25%);; display:inline">676</div>
                        <div style="color: hsl(225, 100%, 25%);; display:inline">676</div>
                        <div style="color: hsl(224, 100%, 25%);; display:inline">673</div>
                        <div style="color: hsl(225, 100%, 25%);; display:inline">675</div>
                        <div style="color: hsl(224, 100%, 25%);; display:inline">674</div>
                        <div style="color: hsl(225, 100%, 25%);; display:inline">676</div>
                        <br/><span><div style="color: hsl(225, 100%, 25%);; display:inline">676.30</div> <div
                                style="color: hsl(225, 100%, 25%);; display:inline">676.40</div> <div
                                style="color: hsl(224, 100%, 25%);; display:inline">673.20</div> <div
                                style="color: hsl(225, 100%, 25%);; display:inline">675.20</div> <div
                                style="color: hsl(224, 100%, 25%);; display:inline">674.20</div> <div
                                style="color: hsl(225, 100%, 25%);; display:inline">675.50</div><br/> ( UTC)</span></a>
                </td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=0bc6e4&type=temp">
                        <div style="color: hsl(221, 100%, 30%);; display:inline">46</div>
                        <div style="color: hsl(227, 100%, 30%);; display:inline">45</div>
                        <div style="color: hsl(221, 100%, 30%);; display:inline">46</div>
                        <div style="color: hsl(227, 100%, 30%);; display:inline">45</div>
                        <div style="color: hsl(198, 100%, 30%);; display:inline">50</div>
                        <div style="color: hsl(227, 100%, 30%);; display:inline">45</div>
                        <span align="left"><div style="color: #000; display:inline">00</div>  ( UTC)</span></a></td>
                <td align="right"><a href="#" class="hasTooltip">
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <span>n/a</span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=0bc6e4&type=fanrpm">
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <span>percents: 84 84 84 84 84 84<br/>k-rpms: <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> </span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=0bc6e4&type=core">
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <span><div style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> </span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=0bc6e4&type=mem">
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <span><div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> </span></a></td>
                </tr>
                <td align="left">1.1.8</td>
                <td align="left"><a class="hasTooltip">
                        <div style="display: inline; color: hsl(185, 89%, 23%)">sg-x</div>
                        <span>sgminer-gm-xmr 5.5.4-gm</span></a></td>
                <td align="left"><a href="#" class="hasTooltip" style="color:black">
                        <div style=" display:inline; color: hsl(100, 100%, 25%);">4/4</div>
                        <span>8gb &middot; 01 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 02 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 03 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb<br/>8gb &middot; 04 ellesmere rx 480 113-2e3470u.s5s samsung &middot;
                            113-2e3470u.s5s &middot; &middot; samsung k4g80325fb</span></a></td>
                <td align="left">
                    <div style="display:inline; font-family: monospace;">
                        <a href="#" class="hasTooltip"
                           style="color: hsl(37, 92%, 21%); text-decoration: none">cbda8b<span>2694.1 hash: miner active<br/>TA970<br/>KingDian S200 60GB 2016111000029<br/>Realtek Semiconductor Co., Ltd. RTL8111/8168/8411 PCI Express Gigabit Ethernet Controller (rev 07)<br/>4.8.0-rc6-ethos3<br/>AMD Phenom(tm) II X2 B59 Processor<br/>
AMD Phenom(tm) II X2 B59 Processor</span></div>
                </td>
                <td align="left"></td>
                <td align="right"><a target=_blank href="http://192.168.0.32/"><span
                            style="color: #006; text-decoration: underline" class="ip_address">192.168.0.32</span></a>
                </td>
                <td align="right"><a class="hasTooltip">
                        <div style="display: inline; color: #00a">s47</div>
                        <span>Jan 16 2017 22:35:36 UTC<br/>0 days, 0 hours, 0 mins, 47 sec</span></a></td>
                <td align="right"><a class="hasTooltip">
                        <div style="display: inline; color: #090">h7</div>
                        <span>Jan 16 2017 14:56:05 UTC<br/>0 days, 7 hours, 40 mins, 18 sec</span></a></td>
                <td align="right"></td>
                <td align="right"><a href="/graphs/?rig=cbda8b&type=rx_kbps"><span style="color: hsl(252, 100%, 30%);">0.1</span></a>
                </td>
                <td align="right"><a href="/graphs/?rig=cbda8b&type=tx_kbps"><span style="color: hsl(250, 100%, 30%);">0.1</span></a>
                </td>
                <td align="right"><a href="/graphs/?rig=cbda8b&type=load"><span
                            style="color: hsl(223, 100%, 30%);">0.2</span></a></td>
                <td align="right"><a href="/graphs/?rig=cbda8b&type=cpu_temp"><span style="color: hsl(224, 100%, 30%);">26</span></a>
                </td>
                <td align="right">4</td>
                <td align="right"><span style="color: hsl(173, 100%, 30%);">6</span></td>
                <td align="right"><a href="/graphs/?rig=cbda8b&type=hash" class="hasTooltip"
                                     style="color: hsl(162, 92%, 24%) ">2694<span>stratumproxy enabled<br/>
proxywallet ...82<br/>
proxypool1 pool.minexmr.com:7777<br/>
proxypool2 pool.minexmr.com:5555<br/>
</span></a></td>
                <td align="right"><a class="hasTooltip" align="left" href="/graphs/?rig=cbda8b&type=miner_hashes">
                        <div style="color: hsl(225, 100%, 25%);; display:inline">675</div>
                        <div style="color: hsl(224, 100%, 25%);; display:inline">673</div>
                        <div style="color: hsl(224, 100%, 25%);; display:inline">673</div>
                        <div style="color: hsl(224, 100%, 25%);; display:inline">673</div>
                        <br/><span><div style="color: hsl(225, 100%, 25%);; display:inline">675.00</div> <div
                                style="color: hsl(224, 100%, 25%);; display:inline">673.10</div> <div
                                style="color: hsl(224, 100%, 25%);; display:inline">673.00</div> <div
                                style="color: hsl(224, 100%, 25%);; display:inline">673.00</div><br/> ( UTC)</span></a>
                </td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=cbda8b&type=temp">
                        <div style="color: hsl(198, 100%, 30%);; display:inline">50</div>
                        <div style="color: hsl(238, 100%, 30%);; display:inline">43</div>
                        <div style="color: hsl(227, 100%, 30%);; display:inline">45</div>
                        <div style="color: hsl(215, 100%, 30%);; display:inline">47</div>
                        <span align="left"><div style="color: #000; display:inline">00</div>  ( UTC)</span></a></td>
                <td align="right"><a href="#" class="hasTooltip">
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <div style="display:inline; color: hsl(26, 100%, 30%);">5</div>
                        <span>n/a</span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=cbda8b&type=fanrpm">
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <div style="color: hsl(193, 100%, 30%);; display:inline">4</div>
                        <span>percents: 84 84 84 84<br/>k-rpms: <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> <div
                                style="color: hsl(193, 100%, 30%);; display:inline">3.8</div> </span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=cbda8b&type=core">
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <div style="color: hsl(249, 100%, 30%);; display:inline">1.19</div>
                        <span><div style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> <div
                                style="color: hsl(297, 100%, 30%);; display:inline">1.27</div> </span></a></td>
                <td align="right"><a class="hasTooltip" href="/graphs/?rig=cbda8b&type=mem">
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div>
                        <span><div style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> <div
                                style="color: hsl(425, 100%, 30%);; display:inline">2.00</div> </span></a></td>
                </tr></table>
        </div>
    </div>
</div>
<br/>
<div class="alert alert-success" style="margin-left: 2em; margin-right: 2em" role="alert">Check out the <a
        href="http://gpushack.com/collections/gpushack/products/gpushack-frame">gpuShack Open-Air Frame</a></div>
<div style="margin-left: 2em"></div>
<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
</body>
</html>
