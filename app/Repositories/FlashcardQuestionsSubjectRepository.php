<?php

namespace App\Repositories;

use App\Models\FlashcardQuestionsSubject;
use App\Repositories\BaseRepository;

/**
 * Class FlashcardQuestionsSubjectRepository
 * @package App\Repositories
 * @version May 21, 2021, 7:24 am UTC
*/

class FlashcardQuestionsSubjectRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'flashcard_questions_id',
        'flashcard_subjects_id'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FlashcardQuestionsSubject::class;
    }
}
