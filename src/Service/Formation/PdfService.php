<?php

namespace App\Service\Formation;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

use Twig\Environment;

class PdfService
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $pdfDirectory;

    protected $chrootDirectory;

    public function __construct(Environment $twig, string $pdfDirectory, string $chrootDirectory)
    {
        $this->twig = $twig;
        $this->pdfDirectory = $pdfDirectory;
        $this->chrootDirectory = $chrootDirectory;
    }

    public function getTrainingPdf()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('chroot', $this->chrootDirectory);
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsHtml5ParserEnabled(true);
        $pdfOptions->setDpi(150);

        // instantiate Dompdf with the options
        $dompdf = new Dompdf($pdfOptions);

        // retrieve the HTML generated in the twig file
        $html = $this->twig->render('pdf/formation.html.twig', [
            'title' => "PDF de la formation"
        ]);

        // load HTML to Dompdf
        $dompdf->loadHtml($html);
        //
        //dd($dompdf);
        //
        // (Optional) setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // render the HTML as PDF
        $dompdf->render();

        // store PDF Binary Data
        $output = $dompdf->output();

        //  write the file in the public directory set in config/services.yaml
        $publicDirectory = $this->pdfDirectory;
        // concatenate the name with the facture id
        $pdfFilepath =  $publicDirectory . '/formation-test.pdf';

        // write file to the desired path
        file_put_contents($pdfFilepath, $output);

        // output the generated PDF to Browser (force download)
        $dompdf->stream("formation-pdf.pdf", [
            "Attachment" => false
        ]);
    }
}
