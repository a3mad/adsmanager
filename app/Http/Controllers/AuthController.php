<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    use ApiResponser;

    /**
     * @param Request $request
     * @return Response|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'sometimes'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->errorResponse(__('auth.failed'), 401);
        }
        $user = $request->user();
        /*if (!$user->email_verified_at) {
            return $this->errorResponse(__('auth.not_verified'), 401);
        }*/
        $tokenResult = $user->createToken('BioStudios');
        $token = $tokenResult->token;
        if ($request->input('remember_me')) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        $result = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user
        ];
        return $this->successResponse($result);
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate([
            'fcm_token' => 'required|string',
        ]);
        $user = User::find(Auth::id());
        $user->fcm_token = $request->input('fcm_token');
        $user->save();
        return $this->successResponse(['user' => $user]);
    }

    /*  public function sendResetLinkEmail(ResetPasswordEmailRequest $request)
      {
          $data = $request->userData();

          Mail::to($data['email'])->send(new ResetPasswordEmail($data));

          return $this->successResponse([], 200, __('passwords.sent'));
      }

      public function resetPassword(ResetPasswordRequest $request)
      {
          if ($request->updateUserPassword()) {
              return $this->successResponse([], 200, __('passwords.reset'));
          }

          return $this->errorResponse([], 400, __('app.data_failed'));
      }

      public function verifyEmail($email, $verifyToken)
      {
          $user = User::where(['email' => $email, 'email_verify_token' => $verifyToken])->firstOrFail();
          if (null != $user->email_verified_at)
          {
              return $this->errorResponse([], 400, __('app.data_failed'));
          }
          $user->update(['email_verified_at' => Carbon::now()->toDateTimeString()]);

          return $this->successResponse([], 200, __('auth.verified'));
      }

      public function resendVerifyEmail($email)
      {
          $user = User::where('email', $email)->firstOrFail();
          if ($user) {
              if (null != $user->email_verified_at) {
                  return $this->errorResponse([], 400, __('app.data_failed'));
              }
              $user->email_verify_token = mt_rand(111111, 999999);
              $user->save();
              $user->refresh();
              Helpers::sendVerifyEmail($user->email, $user->email_verify_token);
              return $this->successResponse([], 200, __('app.data_created'));
          }
          return $this->errorResponse([], 400, __('app.data_failed'));
      }*/

    /**
     * @param Request $request
     * @return Response|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $this->successResponse(['message' => 'Successfully logged out']);
    }
}
