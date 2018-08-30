<?
public function editAction(Request $request, $idNendo)
{
 $em = $this->getDoctrine()->getManager();
 $repositoryNendo = $em->getRepository(Nendoroid::class);
 $nendoroid = $repositoryNendo->find($idNendo);

 $form = $this->createForm(NendoroidType::class, $nendoroid);

 if($request->isMethod('POST')) 
 {
   $form->handleRequest($request);

   if($form->isValid()) 
   {
     $em = $this->getDoctrine()->getManager();
     $em->persist($nendoroid);
     $em->flush();

     return $this->redirectToRoute('otaku_project_list');
   }
 }
 return $this->render('otakuProjectnendoroidBundle:nendoroidViews:add.html.twig', array('form' => $form->createView()));
}