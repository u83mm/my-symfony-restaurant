<?php

namespace App\Controller;

use App\Entity\fpdf\MyPdf;
use App\Repository\DishMenuRepository;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfGeneratorMenuController extends AbstractController
{
    #[Route('/pdf/generator/menu', name: 'app_pdf_generator_menu')]
    public function index(DishMenuRepository $dishMenuRepository, DishRepository $dishRepository): Response
    {
        try {
            define('FPDF_FONTPATH', $this->getParameter('pdf_fonts'));
            define('EURO_SIMBOL', chr(128)); 

            $pdf = new MyPdf();       
            
            $menuCategories = $dishMenuRepository->findAll();                               

            /** Start to build the menu */

            $pdf->title = "Nuestra Carta";        
            $pdf->SetFillColor(0, 54.5, 54.5);           
            $pdf->AddPage();
            $pdf->AliasNbPages();
            $pdf->SetFont('GreatVibes','',18); 


            /** Show all the categories and their dishes*/

            foreach ($menuCategories as $key => $category) {                
                $pdf->Cell(150, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($category->getMenuCategory())), 0, 0, '');
                $pdf->Cell(0, 10, "Precio", 0, 0, "");                             
                $pdf->Rect(10, $pdf->getY()+10, 170, 2, "F");                                               
                $pdf->Ln(10);


                /** Show dishes */

                $rows = $dishRepository->findBy(['dishMenu' => $category->getId()]);                                                                       

                foreach ($rows as $key => $value) {
                
                    $pdf->SetFont('GreatVibes','',14);
                    if($value->getAvailable() === true) {                    
                        $pdf->Cell(150, 10, iconv('UTF-8', 'ISO-8859-1', ucfirst($value->getName())), 0, 0, 'L');
                        $pdf->Cell(20, 10, $value->getPrice() . " " . EURO_SIMBOL, 0, 0, 'R');
                        $pdf->Ln(5);                                                                  
                    }
                    
                    $pdf->SetFont('GreatVibes','',18);
                }
                $pdf->Ln(20);
            } 
            
            return new Response (
                $pdf->Output('', 'Menu.pdf'),         
            );
            
        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }                        
    }
}
