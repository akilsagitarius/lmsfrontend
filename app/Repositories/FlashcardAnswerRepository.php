<?php

namespace App\Repositories;

use App\Models\FlashcardAnswer;
use App\Repositories\BaseRepository;

/**
 * Class FlashcardAnswerRepository
 * @package App\Repositories
 * @version June 21, 2021, 6:03 am UTC
*/

class FlashcardAnswerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'flashcard_questions_id',
        'group',
        'choice'
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
        return FlashcardAnswer::class;
    }
}
