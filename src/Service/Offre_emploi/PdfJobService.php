<?php

namespace App\Service\Offre_emploi;

use App\Entity\JobOffer;
use App\Repository\JobOfferRepository;
// Include Dompdf required namespaces
use Dompdf\Dompdf;
use Dompdf\Options;

use Twig\Environment;

class PdfJobService
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var string
     */
    protected $pdfJobDirectory;

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
     * @param string $pdfJobDirectory 
     * @param string $chrootDirectory 
     * @param TrainingRepository $repo 
     * @return void 
     */
    public function __construct(Environment $twig, string $pdfJobDirectory, string $chrootDirectory, JobOfferRepository $repo)
    {
        $this->twig = $twig;
        $this->pdfJobDirectory = $pdfJobDirectory;
        $this->chrootDirectory = $chrootDirectory;
        $this->repo = $repo;
    }

    public function getJobOfferPdf(JobOffer $jobOffer)
    {
        // Récupère les information de l'offre sélectionnée' sélectionnée
        $job = $this->repo->find($jobOffer->getId());
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
        $html = $this->twig->render('pdf/job_offer.html.twig', [
            'job' => $job,
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
        $publicDirectory = $this->pdfJobDirectory;
        // concatenate the name with the facture id
        $pdfFilepath =  $publicDirectory . '/' . $job->getSlug() . '.pdf';

        // write file to the desired path
        file_put_contents($pdfFilepath, $output);

        // output the generated PDF to Browser (force download)
        $dompdf->stream("offre-emploi-pdf.pdf", [
            "Attachment" => false
        ]);
    }
}
