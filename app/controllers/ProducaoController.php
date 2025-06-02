<?php
require_once 'app/models/ProducaoModel.php';

use Dompdf\Dompdf;

class ProducaoController {
    public function gerarPdf($profissional, $data1, $data2) {
        $model = new ProducaoModel();
        $consultas = $model->buscarProducao($profissional, $data1, $data2);

        $html = '
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .header h1 {
                color: #6f42c1;
                font-size: 20px;
                margin: 0;
            }
            .dia-atendimento {
                background-color: #f3e8ff;
                padding: 10px;
                border-left: 5px solid #6f42c1;
                margin-top: 20px;
                font-weight: bold;
                color: #6f42c1;
            }
            .atendimento {
                border: 1px solid #ddd;
                border-left: 4px solid #d0b3f0;
                margin: 10px 0;
                padding: 10px;
                border-radius: 5px;
                background-color: #fff;
            }
            .titulo {
                font-size: 13px;
                font-weight: bold;
                color: #444;
                margin-bottom: 5px;
            }
            .info {
                margin-bottom: 5px;
            }
            .total-dia {
                font-size: 12px;
                font-weight: bold;
                color: #6f42c1;
                text-align: right;
                margin-top: 10px;
            }
        </style>

        <div class="header">
            <h1>Relatório de Produção - e.prontuario</h1>
        </div>
        ';

        if (empty($consultas)) {
            $html .= "<p>Sem histórico de atendimentos.</p>";
        } else {
            $dataAtual = '';
            $contadorDia = 0;

            foreach ($consultas as $index => $row) {
                $dataFormatada = date('d/m/Y', strtotime($row['data_atendimento']));

                if ($dataFormatada !== $dataAtual) {
                    if ($dataAtual !== '') {
                        $html .= "<div class='total-dia'>Total de atendimentos em $dataAtual: <strong>$contadorDia</strong></div><hr>";
                    }

                    $dataAtual = $dataFormatada;
                    $contadorDia = 0;

                    $html .= "<div class='dia-atendimento'>Atendimentos em $dataAtual - {$row['nome_profissional']}</div>";
                }

                $contadorDia++;

                $html .= "<div class='atendimento'>";
                $html .= "<div class='titulo'>Paciente: {$row['nome_paciente']}</div>";
                $html .= "<div class='info'><strong>Queixa:</strong><br>{$row['queixa_principal']}</div>";
                $html .= "<div class='info'><strong>História da Doença Atual:</strong><br>{$row['historia_doenca_atual']}</div>";
                $html .= "<div class='info'><strong>Conduta:</strong><br>{$row['conduta']}</div>";
                $html .= "</div>";

                if (!isset($consultas[$index + 1]) || date('d/m/Y', strtotime($consultas[$index + 1]['data_atendimento'])) !== $dataAtual) {
                    $html .= "<div class='total-dia'>Total de atendimentos em $dataAtual: <strong>$contadorDia</strong></div><hr>";
                }
            }
        }
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        header("Content-type: application/pdf");
        echo $dompdf->output();
        }
}