<?php

namespace Costa\Core\Utils\Validations;

use Costa\Core\Utils\Abstracts\EntityAbstract;
use Costa\Core\Utils\Contracts\ValidatorInterface;
use Rakit\Validation\Validator;

class VideoRakitValidation implements ValidatorInterface
{
    public function validate(EntityAbstract $entity): void
    {
        $v = new Validator();

        $data = $this->convertEntityForArray($entity);
        $validator = $v->validate($data, [
            'title' => 'required|min:3|max:255',
            'description' => 'nullable|min:3|max:255',
            'yearLaunched' => 'required|integer|min:0',
            'duration' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $entity->notifications->addError([
                    'context' => 'video',
                    'message' => $error,
                ]);
            }
        }
    }

    private function convertEntityForArray(EntityAbstract $entity): array
    {
        return [
            'title' => $entity->title,
            'description' => $entity->description,
            'yearLaunched' => $entity->yearLaunched,
            'duration' => $entity->duration,
        ];
    }
}
