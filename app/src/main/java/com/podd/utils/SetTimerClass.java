package com.podd.utils;


import android.app.Activity;
import android.app.Application;
import android.content.Context;
import android.content.Intent;
import android.os.CountDownTimer;

import com.podd.activityRestaurant.NewHomeScreenActivity;


import java.util.ArrayList;

public class SetTimerClass extends Application {

    private Context context;
    private boolean startAgain;
    private boolean isRunning;
    private CountDownTimer countDownTimer;
    private Activity activity;



    @Override
    public void onCreate() {
        super.onCreate();

        this.context = (SetTimerClass) getApplicationContext();

        // UserInteraction Timer for 15 minutes.
        countDownTimer = new CountDownTimer(900000, 1000) {

            public void onTick(long millisUntilFinished) {
                isRunning = true;
            }

            public void onFinish() {
                //dialog if user is inactive from 15 mins
                isRunning = false;
                CommonUtils.savePreferencesString(context, AppConstant.KEY_IS_INACTIVE, "true");
                Intent intent = new Intent(context, NewHomeScreenActivity.class);
                intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                startActivity(intent);

            }
        };
    }



    public SetTimerClass() {
    }

    public void setTimer(Context context, Boolean startAgain) {
        activity = (Activity) context;
        if (startAgain) {
            if(isRunning){
                countDownTimer.cancel();
                countDownTimer.start();
            }else{
                countDownTimer.start();
            }
        } else {
            countDownTimer.cancel();
        }
    }

    /*public void setTimer(Context context){
        activity = (Activity) context;
    }*/




}
