<?php

namespace App\Http\Controllers;

use App\Models\ProductSold;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use tidy;

class DublicatController extends Controller
{
    public function store(Request $request)
    {
        $inputs = $request->all();
        unset($inputs['_token']);
        // dd($inputs);
        foreach ($inputs as $key => $id) {
            if($newUser = DB::table('new_user_one_months')->where('user_id', $id)->first()) {
                DB::table('new_user_one_months')->where('user_id', $id)->delete();
            }
            if($exercise = DB::table('tg_elchi_exercise')->where('user_id', $id)->first()) {
                DB::table('tg_elchi_exercise')->where('user_id', $id)->delete();
            }
            if($level = DB::table('tg_elchi_level')->where('user_id', $id)->first()) {
                DB::table('tg_elchi_level')->where('user_id', $id)->delete();
            }
            if($elixir = DB::table('tg_elchi_elexir')->where('user_id', $id)->first()) {
                DB::table('tg_elchi_elexir')->where('user_id', $id)->delete();
            }
            if($ball = DB::table('tg_balls')->where('user_id', $id)->first()) {
                DB::table('tg_balls')->where('user_id', $id)->delete();
            }
            if($teacher = DB::table('teachers')->where('user_id', $id)->first()) {
                DB::table('teachers')->where('user_id', $id)->delete();
            }
            if($battle1 = DB::table('tg_battle')->where('user1_id', $id)->first()) {
                DB::table('tg_battle')->where('user1_id', $id)->delete();
            }
            if($battle2 = DB::table('tg_battle')->where('user2_id', $id)->first()) {
                DB::table('tg_battle')->where('user2_id', $id)->delete();
            }
            DB::table('tg_user')->where('id', $id)->delete();
        }
        return redirect()->back();
    }
    public function index()
    {
        $duplicateUsers = [];
        foreach ($this->duplicates() as $key => $duplicates) {
            $duplicateUsers[$key] = [];
            foreach ($duplicates as $id) {
                try {
                    $duplicateUsers[$key][] =
                        DB::select(
                            "SELECT 
                        COALESCE(SUM(p.number * p.price_product), 0) AS prodaja, 
                        u.id, u.username, u.pr,
                        u.first_name,
                        u.last_name,
                        u.date_joined,
                        u.phone_number
                        FROM tg_user AS u
                        LEFT JOIN tg_productssold AS p ON p.user_id = u.id
                        WHERE u.id = ?       
                        GROUP BY u.id",
                            [$id]
                        )[0];
                } catch (\Throwable $th) {
                    $duplicateUsers[$key][] = ['id' => $id, 'error' => $th->getMessage()];
                }
            }
        }
        // $newUserFirst = DB::table('new_user_one_months')->where('user_id', 243)->get();
        // $exerciseFirst = DB::table('tg_elchi_exercise')->where('user_id', 243)->get();
        // $levelFirst = DB::table('tg_elchi_level')->where('user_id', 243)->get();
        // $elixirFirst = DB::table('tg_elchi_elexir')->where('user_id', 243)->get();
        // $ballFirst = DB::table('tg_balls')->where('user_id', 243)->get();
        // $newUserUser = DB::table('new_user_one_months')->where('user_id', 242)->get();
        // $exerciseUser = DB::table('tg_elchi_exercise')->where('user_id', 242)->get();
        // $levelUser = DB::table('tg_elchi_level')->where('user_id', 242)->get();
        // $elixirUser = DB::table('tg_elchi_elexir')->where('user_id', 242)->get();
        // $ballUser = DB::table('tg_balls')->where('user_id', 242)->get();
        // $prodajaFirst = DB::table('tg_productssold')
        //     ->selectRaw('SUM(number * price_product) AS prodaja')
        //     ->where('user_id', 243)->value('prodaja') ;
        // $prodajaUser = DB::table('tg_productssold')
        //     ->selectRaw('SUM(number * price_product) AS prodaja')
        //     ->where('user_id', 242)->value('prodaja');
        // dd(
        //     compact('newUserFirst', 'exerciseFirst', 'levelFirst', 'elixirFirst', 'ballFirst', 'prodajaFirst'),
        //     compact('newUserUser', 'exerciseUser', 'levelUser', 'elixirUser', 'ballUser', 'prodajaUser')
        // );
        // dd($duplicateUsers);
        // return $duplicateUsers;
        return view('dublicat.index', compact('duplicateUsers'));
    }

    private function duplicates()
    {
        $duplicates = [];
        $checked = [];
        $i = 0;
        $countUsers = DB::table('tg_user')->count();
        while ($i < $countUsers) {
            $first = $this->uncheckedUser($duplicates, $checked);
            if (!$first) {
                break;
            }
            $users = $this->uncheckedUsers($duplicates, $checked);
            $dup = [];
            $checked[] = $first->id;
            $hasDuplicate = false;
            foreach ($users as $user) {
                $clauseOne = $first->first_name == $user->first_name;
                $clauseTwo = $first->last_name == $user->last_name;
                $clauseThree = $first->phone_number == $user->phone_number;
                if ($clauseThree || ($clauseOne && $clauseTwo)) {
                    $hasDuplicate = true;
                    $newUserFirst = DB::table('new_user_one_months')->where('user_id', $first->id)->first();
                    $newUserUser = DB::table('new_user_one_months')->where('user_id', $user->id)->first();
                    $exerciseFirst = DB::table('tg_elchi_exercise')->where('user_id', $first->id)->first();
                    $exerciseUser = DB::table('tg_elchi_exercise')->where('user_id', $user->id)->first();
                    $levelFirst = DB::table('tg_elchi_level')->where('user_id', $first->id)->first();
                    $levelUser = DB::table('tg_elchi_level')->where('user_id', $user->id)->first();
                    $elixirFirst = DB::table('tg_elchi_elexir')->where('user_id', $first->id)->first();
                    $elixirUser = DB::table('tg_elchi_elexir')->where('user_id', $user->id)->first();
                    $ballFirst = DB::table('tg_balls')->where('user_id', $first->id)->first();
                    $ballUser = DB::table('tg_balls')->where('user_id', $user->id)->first();
                    $prodajaFirst = DB::table('tg_productssold')
                        ->selectRaw('SUM(number * price_product) AS prodaja')
                        ->where('user_id', $first->id)->value('prodaja') ?? 0;
                    $prodajaUser = DB::table('tg_productssold')
                        ->selectRaw('SUM(number * price_product) AS prodaja')
                        ->where('user_id', $user->id)->value('prodaja') ?? 0;
                    if ($prodajaUser > $prodajaFirst) {
                        $mid = $first;
                        $first = $user;
                        $user = $mid;
                    } else if ($prodajaUser == $prodajaFirst) {
                        if (
                            $newUserUser && $exerciseUser && $levelUser && $elixirUser && $ballUser &&
                            !$newUserFirst && !$exerciseFirst && !$levelFirst && !$elixirFirst && !$ballFirst
                        ) {
                            $mid = $first;
                            $first = $user;
                            $user = $mid;
                        } else if ($user->date_joined > $first->date_joined) {
                            $mid = $first;
                            $first = $user;
                            $user = $mid;
                        }
                    } else if (true) {
                    }
                    array_push($dup, $user->id);
                }
            }
            if ($hasDuplicate) {
                array_unshift($dup, $first->id);
            }
            if (count($dup) > 0) {
                $duplicates[] = $dup;
            }
            $i++;
        }
        return $duplicates;
    }

    private function uncheckedUsers($duplicates, $checked)
    {
        $users = [];
        foreach ($duplicates as $key => $id) {
            $users = array_merge($users, $id);
        }
        $users = array_merge($users, $checked);

        return DB::table('tg_user')
            ->whereNotIn('id', $users)
            ->orderBy('id', 'DESC')
            ->offset(1)
            ->get();
    }
    private function uncheckedUser($duplicates, $checked)
    {
        $users = [];
        foreach ($duplicates as $key => $id) {
            $users = array_merge($users, $id);
        }
        $users = array_merge($users, $checked);
        return DB::table('tg_user')
            ->whereNotIn('id', $users)
            ->orderBy('id', 'DESC')
            ->first();
    }
}
