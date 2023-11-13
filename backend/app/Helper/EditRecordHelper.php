<?php
use App\Models\EditRecord;
use Illuminate\Support\Carbon;

    function addRec(string $section, int $user_id, int $role_id, string $addedValue){
        EditRecord::create([
            'action' => 'Add',
            'section' => $section,
            'message' => 'Add '. $addedValue,
            'user_id' => $user_id,
            'role_id' => $role_id,
        ]);
        return 0;
    }

    function editRec(string $section, int $user_id, int $role_id, string $before, string $after){
        EditRecord::create([
            'action' => 'Edit',
            'section' => $section,
            'message' => 'Edit '. $before . ' to '. $after,
            'user_id' => $user_id,
            'role_id' => $role_id,
        ]);
        return 0;
    }

    function deleteRec(string $section, int $user_id, int $role_id, string $deletedValue){
        EditRecord::create([
            'action' => 'Delete',
            'section' => $section,
            'message' => 'Delete '. $deletedValue,
            'user_id' => $user_id,
            'role_id' => $role_id,
        ]);
        return 0;
    }

?>
