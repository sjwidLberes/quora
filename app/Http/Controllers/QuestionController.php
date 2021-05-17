<?php

namespace App\Http\Controllers;

use App\Http\Repositories\QuestionRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreQuestionRequest;

class QuestionController extends Controller
{
    protected $questionRepository;
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionFeed();
        return view('question.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $topics = $this->questionRepository->normalizeTopics($request->topics);//将未创建的话题创建，返回话题ID数组
        $attr = [
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ];
        $question = $this->questionRepository->createQuestion($attr);
        $question->topics()->attach($topics);
        $question->user->increment('ask_count');
        return redirect()->route('question.show',$question->id);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->byId($id);
        return view('question.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question)){
            return view('question.edit',compact('question'));
        }else{
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $question->title = $request->title;
        $question->body = $request->body;
        $question->save();
        $topics = $this->questionRepository->normalizeTopics($request->topics);
        $question->topics()->sync($topics);
        return redirect()->route('question.show',$question->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);
        if(Auth::user()->owns($question)){
            $question->user->decrement('ask_count');
            $question->delete();
            return redirect()->route('question.index');
        }else{
            return back();
        }
    }

    public function follow($id){
        $question = $this->questionRepository->byId($id);
        $question->followed_users()->toggle(Auth::id());
        $question->increment('follower_count');
        return back();
    }
}
