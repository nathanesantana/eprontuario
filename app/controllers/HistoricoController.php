<?php
require_once 'app/models/HistoricoModel.php';

use Dompdf\Dompdf;

class HistoricoController {
    public function gerarPdf($paciente, $data1, $data2) {
        $model = new HistoricoModel();
        $consultas = $model->buscarHistorico($paciente, $data1, $data2);

        $html = '
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; color: #333; }
            .atendimento {
                border: 1px solid #ccc;
                border-left: 5px solid #6f42c1;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 5px;
                background-color: #f9f9f9;
            }
            .titulo { font-size: 14px; font-weight: bold; color: #6f42c1; margin-bottom: 5px; }
            .subtitulo { font-size: 12px; font-weight: bold; color: #444; margin-bottom: 10px; }
            .info { margin-bottom: 8px; }
            .logo { font-size: 18px; color: #6f42c1; font-weight: bold; margin-bottom: 30px; }
            .vazio { font-size: 13px; color: #666; margin-top: 20px; }
        </style>
        <div class="logo">e.prontuario - Histórico de Atendimentos</div>
        ';

        if (count($consultas) === 0) {
            $html .= "<div class='vazio'>Sem histórico de atendimentos</div>";
        } else {
            foreach ($consultas as $row) {
                $data = date('d/m/Y', strtotime($row['data_atendimento']));
                $html .= "<div class='atendimento'>";
                $html .= "<div class='titulo'>Consulta do(a) paciente {$row['nome_paciente']}</div>";
                $html .= "<div class='subtitulo'>$data - Profissional: {$row['nome_profissional']}</div>";
                $html .= "<div class='info'><strong>Queixa:</strong><br>{$row['queixa_principal']}</div>";
                $html .= "<div class='info'><strong>História da Doença Atual:</strong><br>{$row['historia_doenca_atual']}</div>";
                $html .= "<div class='info'><strong>Conduta:</strong><br>{$row['conduta']}</div>";
                $html .= "</div>";
            }
        }

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream("consultas.pdf", ["Attachment" => false]);
    }
}
