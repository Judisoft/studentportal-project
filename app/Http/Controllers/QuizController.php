<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Level;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizScore;
use App\Models\Topic;
use Auth;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function displayQuizzes()
    {
        $subjects = Subject::all();
        return view('quizzes', compact('subjects'));
    }

    public function quizGenerator(Quiz $quiz, Request $request)
    {
        $subjects = Subject::all();        
        $questions = $quiz->questions;

        $quiz_time = 0;
        $quiz_points = 0;

        foreach($questions as $question)
        {
            $quiz_time += $question->duration;
            $quiz_points += $question->points;
        }
        
        return view('quiz-detail', compact('questions', 'subjects', 'quiz', 'quiz_time', 'quiz_points'));
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUserQuiz($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        return view('user_quiz', compact('quiz'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validator = $request->validate([
        //     
        // ]);

        $quiz = new QuizQuestion;
        $quiz->question_id = $request->question_id;
        $quiz->quiz_id = $request->quiz_id;

        $quiz->save();

        if($quiz)
        {
            return response()->json([
                'success' => 'question'.' '.$request->question_id .' '. 'saved successfully'
            ]);
        } else {
            return response()->json([
                'error' => 'Oups something went wrong'
            ]);
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sortQuizQuestions(Request $request)
    {
        return response()->json($request);
    }

    /**
     * add questions to quiz item
     */

    public function addQuizQuestions($subject_id,$quiz_id)
    {
        $questions = Question::where('subject_id', $subject_id)->orderBy('subject_id')->simplePaginate(25);
        $user_quiz = Quiz::find($quiz_id);
        $subject = Subject::find($subject_id);
        return view('add-quiz-questions', compact('questions', 'user_quiz', 'subject'));
    }

    public function getAllQuizzess(Request $request)
    {
        $search = $request->input('search');
        // $recommended_quizzes = Quiz::where('user_id', )

        // $quiz_quests = Quiz::find()

        if($search)
        {
            $quizzes = Quiz::query()->where('title', 'LIKE', "%{$search}%")->simplePaginate(21);
            // $quizzes = Quiz::query()->where('title', '=', $search)->simplePaginate(21);
        } else {
            $quizzes = Quiz::simplePaginate(21);
        }
        return view('all-quizzes', compact('quizzes'));
    }


    public function printAnswers(Quiz $quiz)
    {
        return view('answers', compact('quiz'));
    }

    public function postUserScore(Request $request) {   

        $quiz_score = new QuizScore;
        $quiz_score->quiz_id = $request->quiz_id;
        $quiz_score->user_id = $request->user_id;
        $quiz_score->score = $request->user_score;
        $quiz_score->max_quiz_score = $request->max_quiz_score;

        // Find and update quiz attempts
        
        $quiz_attempts = QuizScore::select('attempts')->where('user_id', Auth::user()->id)
                                                      ->where('quiz_id', $request->quiz_id)
                                                      ->get();

        if(json_decode(json_encode($quiz_attempts)) == [])
        {
            $quiz_score->attempts = 1;
        } else {
        $att = max(json_decode(json_encode($quiz_attempts)));
            $quiz_score->attempts = $att->attempts + 1;
        }

        $quiz_score->save();

        return response()->json('success', 201);
    }
}
