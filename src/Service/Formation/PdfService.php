<?php

namespace App\Service\Formation;

// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Entity\Training;
use App\Repository\TrainingRepository;
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

    /**
     * @var string
     */
    protected $chrootDirectory;

    /**
     * @var TrainingRepository
     */
    protected $repo;

    /**
     * @param Environment $twig 
     * @param string $pdfDirectory 
     * @param string $chrootDirectory 
     * @param TrainingRepository $repo 
     * @return void 
     */
    public function __construct(Environment $twig, string $pdfDirectory, string $chrootDirectory, TrainingRepository $repo)
    {
        $this->twig = $twig;
        $this->pdfDirectory = $pdfDirectory;
        $this->chrootDirectory = $chrootDirectory;
        $this->repo = $repo;
    }

    public function getTrainingPdf(Training $training)
    {
        // Récupère les information de la formation sélectionnée
        $formation = $this->repo->find($training->getId());
        //
        // dd($formation);
        //
        $pdfOptions = new Options();
        $pdfOptions->set('chroot', $this->chrootDirectory);
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsHtml5ParserEnabled(true);
        $pdfOptions->setDpi(150);

        // instantiate Dompdf with the options
        $dompdf = new Dompdf($pdfOptions);

        // retrieve the HTML generated in the twig file
        $html = $this->twig->render('pdf/formation.html.twig', [
            'formation' => $formation,
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
        $pdfFilepath =  $publicDirectory . '/' . $formation->getSlug() . '.pdf';

        // write file to the desired path
        file_put_contents($pdfFilepath, $output);

        // output the generated PDF to Browser (force download)
        $dompdf->stream("formation-pdf.pdf", [
            "Attachment" => false
        ]);
    }
}
