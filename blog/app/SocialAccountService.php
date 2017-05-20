<?php
/**
 * Created by PhpStorm.
 * User: FUAD
 * Date: 5/9/2017
 * Time: 12:36 AM
 */

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Linked_social_account as  LinkedSocialAccount;

class SocialAccountService
{
    public function findOrCreate(ProviderUser $providerUser, $provider)
    {
        $account = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $user = User::where('email', $providerUser->getEmail())->first();

            if (! $user) {
                if($providerUser->getEmail()){
                    $mail = $providerUser->getEmail();
                }
                else{
                    $mail = $providerUser->getName()."@facebook.com";
                }
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                ]);
            }

            $user->accounts()->create([
                'provider_id'   => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;

        }
    }
}