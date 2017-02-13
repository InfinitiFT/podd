package com.podd.utils;


import android.app.Activity;
import android.app.Application;
import android.content.Context;
import android.content.Intent;
import android.os.CountDownTimer;
import com.podd.activityRestaurant.NewHomeScreenActivity;
import com.podd.model.SavedItem;



import java.util.ArrayList;

public class SetTimerClass extends Application {

    private Context context;
    private boolean startAgain;
    private boolean isRunning;
    private CountDownTimer countDownTimer;
    private Activity activity;
    public static ArrayList<SavedItem> savedList = new ArrayList<>();


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
                //dialog if user is inactive from 15 minutes
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
    public static  double getTotalPrice() {
        double price = 0.0;

        if (savedList != null) {
            for (int i = 0; i < savedList.size(); i++) {
                try {
                    if (savedList.get(i).count > 0) {
                        price = price + (savedList.get(i).count * Double.parseDouble(savedList.get(i).price));
                    }

                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }
        return price;
    }



}
