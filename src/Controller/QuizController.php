<?php

namespace App\Controller;

use App\Repository\QuizRepository;
use App\Controller\Admin\EntityType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz')]
    public function index(QuizRepository $quizRepository): Response
    {

        // $quiz = $quizRepository->findAll();
        // dd($category);
        // $categoryName = $quiz->getCategory()->getCategoryName();
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('quiz/index.html.twig', [
            // 'controller_name' => 'QuizController',
            'quizzes' => $quizRepository->findAll(),

        ]);
    }


    #[Route('/quiz/{id}', name: 'app_quiz_onequiz', methods: ['GET'])]
    public function onequiz(QuizRepository $quizRepository): Response
    {
        $rest_api = "https://opentdb.com/api.php?amount=10&category=9&type=multiple";
        // Reads the JSON file.
        try {
            $json_data = file_get_contents($rest_api);

            if ($json_data === false) {
                throw new \Exception('Error fetching data from API.');
            }
            //converting json string to an associative array
            $data = json_decode($json_data, true);

            // Pass the JSON data to the Twig template
            // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            return $this->render('quiz/onequiz.html.twig', [
                'onequiz' => $quizRepository,
                'questions' => json_encode($data['results'])
            ]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            // You can customize the error handling based on your needs
            return new Response('An error occurred while fetching the data.', 500);
        }
    }
}
