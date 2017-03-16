package com.podd.activityTaxi;

import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.net.Uri;
import android.util.Log;

/**
 * Created by Raj Kumar on 3/1/2017
 * for Mobiloitte
 */

public class DeepLinking {

    private static final String TAG = "DeepLinking";
    public static void openHailoApp(Context context, String pickUpLat, String pickUpLng, String pickUpAddress, String destinationLat, String destinationLng,
                                    String destinationAddress, String hailoAppToken) {
        String uriString;
        try {
            context.getPackageManager().getPackageInfo("com.hailocab.consumer", PackageManager.GET_ACTIVITIES);

            uriString = "hailoapp://confirm?pickupCoordinate=" + pickUpLat + "," + pickUpLng +
                    "&pickupAddress=" + pickUpAddress + "&destinationCoordinate=" + destinationLat + "," + destinationLng + "&destinationAddress=" + destinationAddress
                    + "&referrer=" + hailoAppToken;

            Log.e(TAG, " **HailoURI** " + uriString);

        } catch (PackageManager.NameNotFoundException e) {
            uriString = "market://details?id=com.hailocab.consumer&referrer=your_hailo_application_token";
        }
        context.startActivity(new Intent("android.intent.action.VIEW", Uri.parse(uriString)));
    }
}
