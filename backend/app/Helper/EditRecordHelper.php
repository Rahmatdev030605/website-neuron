<?php
use App\Models\EditRecord;
use Illuminate\Support\Carbon;

    function addRec(string $section, int $user_id, int $role_id, string $addedValue, string $SpecSec=null){
        $message = "";
        if($SpecSec != null){
            $message = "Section: <b>".$SpecSec ."</b> \r\n";
        }
        $message = $message . "Add <b>". $addedValue."</b> \r\n";
        $message = nl2br($message);
        EditRecord::create([
            'action' => 'Add',
            'section' => $section,
            'message' => $message,
            'user_id' => $user_id,
            'role_id' => $role_id,
        ]);
        return 0;
    }

    function editRec(string $section, int $user_id, int $role_id, object $before, object $after, string $SpecSec){
        unset($before->created_at);
        unset($before->updated_at);
        unset($after->created_at);
        unset($after->updated_at);
        $before = $before->getAttributes();
        $after = $after->getAttributes();
        $message = "Section: <b>".$SpecSec ."</b> \r\n";

        foreach ($before as $key => $valueBefore) {
            if (array_key_exists($key, $after)) {
                $valueAfter = $after[$key];
                if ($valueBefore !== $valueAfter) {
                    $message = $message . "<b>" .$valueBefore ."</b> to <b>" . $valueAfter . "</b> \r\n";
                }
            }
        }
        $message = nl2br($message);

        EditRecord::create([
            'action' => 'Edit',
            'section' => $section,
            'message' => $message,
            'user_id' => $user_id,
            'role_id' => $role_id,
        ]);
        return 0;
    }

    function deleteRec(string $section, int $user_id, int $role_id, string $deletedValue, string $SpecSec=null){
        $message = "";
        if($SpecSec != null){
            $message = "Section: <b>".$SpecSec ."</b> \r\n";
        }
        $message = $message . "Delete <b>". $deletedValue."</b> \r\n";
        $message = nl2br($message);
        EditRecord::create([
            'action' => 'Delete',
            'section' => $section,
            'message' => $message,
            'user_id' => $user_id,
            'role_id' => $role_id,
        ]);
        return 0;
    }

?>
