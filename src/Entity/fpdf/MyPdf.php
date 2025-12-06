<?php

    namespace App\Entity\fpdf;

    use App\Entity\fpdf\Fpdf;    

    class MyPdf extends Fpdf
    {        
        public string $title;

        public function header()
        {
            $this->Image('images/main_logo.png', 10, 8, 33);
            //$this->SetFont('Arial','IBU',20);
            $this->AddFont("GreatVibes", "", "GreatVibes-Regular.php");
            $this->SetFont('GreatVibes','',25); 
            $this->Ln(20);
            $this->Cell(0, 10, $this->title, 0, 0, 'C');
            $this->Ln(20);
        }

        public function footer()
        {
            /** 1,5cm del final */
            $this->SetY(-15);

            $this->SetFont('Arial','I',8);

            /** Número de página */
            $this->Cell(0,10,iconv('UTF-8', 'ISO-8859-1', 'Página ') .$this->PageNo()." de {nb}",0,0,"C");
        }
    }
    
?>