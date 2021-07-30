

public function voice(StoreQuestionRequest $request){
    $question=Question::find($request->post('question_id'));
    if (!$question->user_id==auth()->id()){
        if($question->voice()->user_id == auth()->id()){
            $voice=Voice::where([
            ['user_id','=',auth()->id()],
            ['question_id','=',$request->post('question_id')]
             ])->first();
             $voice->value =$request->post('value');
             if($voice->isDirty()){
                $voice->save();
             }
        }
        $question->voice()->create([
        'user_id'=>auth()->id(),
        'value'=>$request->post('value')
        ]);

        return response()->json([
        'message'=>'Voting completed successfully'
        ]200);
    }
    throw new HttpResponseException(return response()->json([
            'message' => 'The user is not allowed to vote to your question'
        ],406));

    
}

class StoreQuestionRequest{

public function failedValidation(Validator $validator)
    {
 public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_id' => 'required|int|exists:questions,id',
            'value' => 'required|boolean',
        ];
    }
        $errors = $validator->errors()->all();
        throw new HttpResponseException(
            response()->json(['errors' => $errors,
                'message' => 'Denied', 
            ], 406)
        );
    }}
