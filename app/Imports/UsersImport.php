<?php

namespace App\Imports;

use App\Enum\UserType;
use App\Models\User;
use App\Models\UserMembershipDetail;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = DB::transaction(function () use ($row) {
            $user = User::create([
                'email' => $row['email'],
                'password' => $row['password'] ? Hash::make($row['password']) : Hash::make('password'),
                'branch_id' => $row['branch'],
                'phone' => $row['phone'],
                'role_id' => User::User
            ]);
            // Add role in pivot table using relation
            UserProfile::create([
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'address' => $row['address'],
                'gender' => $row['gender'],
                'user_type' => UserType::MEMBER['value'],
                'user_id' => $user->id,
                'created_by' => Auth::id()  ? Auth::id() : $user->id,
                'updated_by' => Auth::id() ? Auth::id() : $user->id,
            ]);

            UserMembershipDetail::create([
                'user_id' => $user->id,
                'name' => $row['membership_duration'],
                'amount' => $row['amount'],
                'remaining_amount' => $row['remaining_amount'],
                'start_date' => $this->changeFormat($row['start_date']),
                'end_date' => $this->changeFormat($row['end_date']),
                'notes' => $row['note']
            ]);
            
            return $user;
        });

        return $user;
    }

    public function changeFormat($date)
    {
        if (empty($date)) {
            return NULL;
        }
        if (!is_string($date)) {
            $readableDate = Carbon::createFromTimestamp(($date - 25569) * 86400)->format('Y/m/d');
            return $readableDate;
        }

        return $date;
    }
}
