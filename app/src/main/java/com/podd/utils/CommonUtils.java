package com.podd.utils;

import android.Manifest;
import android.app.Activity;
import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.ContentUris;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.content.pm.Signature;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Matrix;
import android.graphics.Typeface;
import android.media.ExifInterface;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.Build;
import android.os.Environment;
import android.preference.PreferenceManager;
import android.provider.DocumentsContract;
import android.provider.MediaStore;
import android.support.v4.app.ActivityCompat;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AlertDialog;
import android.text.format.DateFormat;
import android.util.Base64;
import android.util.Log;
import android.util.Patterns;
import android.view.Display;
import android.view.View;
import android.view.ViewGroup;
import android.view.inputmethod.InputMethodManager;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.LinearLayout;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.Toast;


import com.podd.R;

import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.Serializable;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.text.DecimalFormat;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.Locale;
import java.util.TimeZone;


/**
 * The type Common utils.
 */
public class CommonUtils {
    private static final float ALPHA_LIGHT = 0.45f;
    private static final float ALPHA_DARK = 1.0f;
    public final static int PERMISSION_REQUEST_CODE = 101;
    /**
     * The constant accept.
     */
    public static boolean accept;
    /**
     * The constant imageNameLocal.
     */
    public static String imageNameLocal;
    private static ProgressDialog dialogProgress;
    /*private static CustomProgressDialog customProgressDialog;*/
    private static final String TAG = CommonUtils.class.getSimpleName();
    /**
     * The constant chatWindowId.
     */
    public static String chatWindowId;
    /**
     * The constant isFriendRecievedForeGround.
     */
    public static boolean isFriendRecievedForeGround=false;
    /**
     * The constant isChatForeground.
     */
    public static boolean isChatForeground=false;
    /**
     * The constant isNotiForeground.
     */
    public static boolean isNotiForeground=false;

    /**
     * Is network connected boolean.
     *
     * @param mContext the m context
     * @return the boolean
     */
    public static boolean isNetworkConnected(Context mContext) {
        ConnectivityManager cm = (ConnectivityManager) mContext.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo ni = cm.getActiveNetworkInfo();
        return ni != null;
    }

    /**
     * Gets alert with positive button.
     *
     * @param message the message
     * @param context the context
     * @param field   the field
     */
/*  public static String getTimeFromTSDate(String timeStamp) {
        if (timeStamp.length() > 0) {
            return new SimpleDateFormat("hh:mm a")
                    .format(new Date((Long.valueOf(timeStamp) * 1000)));
        } else {
            return "";
        }
    }*/
    public static void showAlertWithPositiveButton(int message, Context context, String field) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(message + " " + field);
        builder.setCancelable(true);
        builder.setPositiveButton("Ok",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        dialog.cancel();
                    }
                });
        AlertDialog alert1 = builder.create();
        alert1.show();
    }

    /**
     * Gets preferences int.
     *
     * @param context the context
     * @param key     the key
     * @return the preferences int
     */
    public static int getPreferencesInt(Context context, String key) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        return sharedPreferences.getInt(key, 0);

    }

    /**
     * Save preference int.
     *
     * @param context the context
     * @param key     the key
     * @param value   the value
     */
    public static void savePreferenceInt(Context context, String key,
                                         int value) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putInt(key, value);
        editor.apply();

    }

    /**
     * Show alert with positive button.
     *
     * @param message the message
     * @param context the context
     * @param field   the field
     */
    public static void showAlertWithPositiveButton(String message, Context context, String field) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(message + " " + field);
        builder.setCancelable(true);
        builder.setPositiveButton("Ok",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        dialog.cancel();
                    }
                });
        AlertDialog alert1 = builder.create();
        alert1.show();
    }

    /**
     * Show alert with positive button.
     *
     * @param message the message
     * @param context the context
     */
    public static void showAlertWithPositiveButton(int message, Context context) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(message);
        builder.setCancelable(true);
        builder.setPositiveButton("Ok",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        dialog.cancel();
                    }
                });
        AlertDialog alert1 = builder.create();
        alert1.show();
    }

    /**
     * Convert path to base 64 string.
     *
     * @param picturePath the picture path
     * @return the string
     */
    public static String convertPathToBase64(String picturePath) {

        if (picturePath != null && picturePath.length() != 0) {
            Bitmap bitmap = BitmapFactory.decodeFile(picturePath);
            ByteArrayOutputStream baos = new ByteArrayOutputStream();
            bitmap.compress(Bitmap.CompressFormat.JPEG, 100, baos);
            bitmap.recycle();
            byte[] bytes = baos.toByteArray();
            Log.e("Common_utils", Base64.encodeToString(bytes, Base64.DEFAULT));
            return Base64.encodeToString(bytes, Base64.DEFAULT);
        }
        return "";
    }

    /**
     * Show alert with positive button.
     *
     * @param message  the message
     * @param context  the context
     * @param editText the edit text
     */
    public static void showAlertWithPositiveButton(String message, Context context, final EditText editText) {
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(message);
        builder.setCancelable(true);
        builder.setPositiveButton("Ok",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        editText.requestFocus();
                        dialog.dismiss();
                    }
                });
        AlertDialog alert1 = builder.create();
        alert1.show();
    }


    /**
     * Validate first name boolean.
     *
     * @param firstName the first name
     * @return the boolean
     */
    public static boolean validateFirstName(String firstName) {
        return firstName.matches("[A-Z][a-zA-Z]*");
    } // end method validateFirstName

    /**
     * Validate last name boolean.
     *
     * @param lastName the last name
     * @return the boolean
     */
// validate last name
    public static boolean validateLastName(String lastName) {
        return lastName.matches("[a-zA-z]+([ '-][a-zA-Z]+)*");
    }


    /**
     * Hide keyboard.
     *
     * @param activity the activity
     */
    public static void hideKeyboard(Activity activity) {
        try {
            InputMethodManager in = (InputMethodManager) activity.getSystemService(Context.INPUT_METHOD_SERVICE);
            View view = activity.findViewById(android.R.id.content);
            in.hideSoftInputFromWindow(view.getWindowToken(),
                    InputMethodManager.HIDE_NOT_ALWAYS);
        } catch (Throwable e) {
            e.printStackTrace();
        }
    }


    /**
     * Is valid email boolean.
     *
     * @param target the target
     * @return the boolean
     */
    public static boolean isValidEmail(CharSequence target) {
        return target != null && Patterns.EMAIL_ADDRESS.matcher(target).matches();
    }

/*
    public static String getDateDiffString(String startDate, String endDate) {*/
/*
        long timeOne = dateOne.getTime();
        long timeTwo = dateTwo.getTime();
        long oneDay = 1000 * 60 * 60 * 24;
        long delta = (timeTwo - timeOne) / oneDay;

        if (delta > 0) {
            return "d" + delta + "d";
        }
        else {
            delta *= -1;
            return "d" + delta + " days before dateOne";
        }
*//*

        java.text.DateFormat formatter = new SimpleDateFormat("dd-MM-yyy");

        try {
            Date date1 = formatter.parse(startDate);
            Date date2 = formatter.parse(endDate);
            long diff = date2.getTime() - date1.getTime();
            long days = TimeUnit.DAYS.convert(diff, TimeUnit.MILLISECONDS);
            if (days < 0)
                days = -days;
            return String.valueOf(days);
        } catch (ParseException e) {
            e.printStackTrace();
            return null;
        }
    }
*/

    /**
     * Show toast.
     *
     * @param context the context
     * @param string  the string
     */
    public static void showToast(Context context, String string) {
        Toast.makeText(context, string, Toast.LENGTH_SHORT).show();
    }

/*
    public static String getDateOfTimestamp(long timeStamp) {
        java.text.DateFormat objFormatter = new SimpleDateFormat("dd-MM-yyy");

        Calendar objCalendar = Calendar.getInstance();

        objCalendar.setTimeInMillis(timeStamp * 1000);//edit
        String result = objFormatter.format(objCalendar.getTime());
        objCalendar.clear();
        return result;

    }
*/

    /**
     * Hide keyboard.
     *
     * @param activity the activity
     */
    public static void hide_keyboard(Activity activity) {
        InputMethodManager inputMethodManager = (InputMethodManager) activity.getSystemService(Activity.INPUT_METHOD_SERVICE);
        //Find the currently focused view, so we can grab the correct window token from it.
        View view = activity.getCurrentFocus();
        //If no view currently has focus, create a new one, just so we can grab a window token from it
        if (view == null) {
            view = new View(activity);
        }
        inputMethodManager.hideSoftInputFromWindow(view.getWindowToken(), 0);
    }

    /**
     * Gets timestamp of date.
     *
     * @param str_date the str date
     * @return the timestamp of date
     */
    public static String getTimestampOfDate(String str_date) {
        java.text.DateFormat formatter = new SimpleDateFormat("dd-MM-yyy",Locale.getDefault());
        Date date = null;
        try {
            date = formatter.parse(str_date);

        } catch (ParseException e1) {
            e1.printStackTrace();
        }
        assert date != null;
        long value = (date.getTime()) / 1000L;
        return String.valueOf(value);
    }

    /**
     * Gets timestamp of date yyymmdd.
     *
     * @param str_date the str date
     * @return the timestamp of date yyymmdd
     */
    public static String getTimestampOfDateYYYMMDD(String str_date) {
        java.text.DateFormat formatter = new SimpleDateFormat("yyy-MM-dd",Locale.getDefault());
        Date date = null;
        try {
            date = formatter.parse(str_date);

        } catch (ParseException e1) {
            e1.printStackTrace();
        }
        assert date != null;
        long value = (date.getTime()) / 1000L;
        String timestampValue = String.valueOf(value);
        return timestampValue;
    }

    public static String getDateAndTimeFromTimeStamp(long timeStamp) {
        if (timeStamp > 0) {
            return new SimpleDateFormat("E, dd MMM yyyy",Locale.getDefault())
                    .format(new Date((Long.valueOf(timeStamp))));
        } else {

            return "";
        }
    }

    public static String getTimeFromTimeStamp(long timeStamp) {
        if (timeStamp > 0) {
            return new SimpleDateFormat("HH:MM a",Locale.getDefault())
                    .format(new Date((Long.valueOf(timeStamp))));
        } else {

            return "";
        }
    }


    /**
     * Gets timestamp of mmddyy.
     *
     * @param str_date the str date
     * @return the timestamp of mmddyy
     */
    public static String getTimestampOfMMDDYY(String str_date) {
        java.text.DateFormat formatter = new SimpleDateFormat("MM/dd/yyy",Locale.getDefault());
        Date date = null;
        try {
            date = formatter.parse(str_date);

        } catch (ParseException e1) {
            e1.printStackTrace();
        }
        assert date != null;
        long value = (date.getTime()) / 1000L;
        return String.valueOf(value);
    }

    /**
     * Add day to date string.
     *
     * @param date    the date
     * @param noOfDay the no of day
     * @return the string
     */
    public static String addDayToDate(String date, int noOfDay) {
        SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyy",Locale.getDefault());
        Date dtStartDate = null;
        try {
            dtStartDate = sdf.parse(date);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        Calendar c = Calendar.getInstance();
        c.setTime(dtStartDate);
        c.add(Calendar.DATE, noOfDay);  // number of days to add
        String resultDate = sdf.format(c.getTime());  // dt is now the new date
        return resultDate;
    }

    /**
     * Add day to date other format string.
     *
     * @param date    the date
     * @param noOfDay the no of day
     * @return the string
     */
    public static String addDayToDateOtherFormat(String date, int noOfDay) {
        SimpleDateFormat sdf = new SimpleDateFormat("dd-MM-yyy",Locale.getDefault());
        Date dtStartDate = null;
        try {
            dtStartDate = sdf.parse(date);
        } catch (ParseException e) {
            e.printStackTrace();
        }
        Calendar c = Calendar.getInstance();
        c.setTime(dtStartDate);
        c.add(Calendar.DATE, noOfDay);  // number of days to add
        return sdf.format(c.getTime());
    }

    /**
     * Save int preferences.
     *
     * @param context the context
     * @param key     the key
     * @param value   the value
     */
    public static void saveIntPreferences(Context context, String key, int value) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putInt(key, value);
        editor.apply();

    }

    /**
     * Gets int preferences.
     *
     * @param context the context
     * @param key     the key
     * @return the int preferences
     */
    public static int getIntPreferences(Context context, String key) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        return sharedPreferences.getInt(key, 0);

    }



    /**
     * Show alert exit.
     *
     * @param context           the context
     * @param titleId           the title id
     * @param messageId         the message id
     * @param positiveButtontxt the positive buttontxt
     * @param positiveListener  the positive listener
     * @param negativeButtontxt the negative buttontxt
     * @param negativeListener  the negative listener
     */
    public static void showAlertExit(Context context, int titleId, int messageId,
                                     CharSequence positiveButtontxt,
                                     DialogInterface.OnClickListener positiveListener,
                                     CharSequence negativeButtontxt,
                                     DialogInterface.OnClickListener negativeListener) {
        Dialog dlg = new AlertDialog.Builder(context)
                // .setIcon(android.R.drawable.ic_dialog_alert)
                .setTitle(titleId)
                .setPositiveButton(positiveButtontxt, positiveListener)
                .setNegativeButton(negativeButtontxt, negativeListener)
                .setMessage(messageId).setCancelable(false).create();

        dlg.show();
    }

    /**
     * Show alert.
     *
     * @param message the message
     * @param v       the v
     * @param context the context
     */
    public static void showAlert(String message, final View v, Context context) {

        if (v != null) {
            v.setEnabled(false);
        }
        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(message)
                .setCancelable(false)
                .setPositiveButton("OK",
                        new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.dismiss();

                                if (v != null) {
                                    v.setEnabled(true);
                                }
                            }
                        });

        try {
            builder.show();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }


    /**
     * Show alert new.
     *
     * @param title   the title
     * @param message the message
     * @param context the context
     */
    public static void showAlertNew(String title, String message,
                                    final Context context) {

        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(message).setCancelable(false).setTitle(title)
                .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {

                    }
                });

        try {
            builder.show();
        } catch (Exception e) {
            e.printStackTrace();
        }

    }

    /**
     * Show alert ok.
     *
     * @param message the message
     * @param context the context
     */
    public static void showAlertOk(String message, Activity context) {


        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(message)
                .setCancelable(false)
                .setPositiveButton("OK",
                        new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.dismiss();


                            }
                        });

        try {
            builder.show();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }


/*
    public final static boolean isValidEmail(CharSequence target) {
		if (target == null) {  
			return false;
		} else {

			return android.util.Patterns.EMAIL_ADDRESS.matcher(target)
					.matches();
		}
	}*/


    /**
     * Is valid phone boolean.
     *
     * @param target the target
     * @return the boolean
     */
    public static boolean isValidPhone(CharSequence target) {
        return target != null && Patterns.PHONE.matcher(target).matches() && (target.length() >= 10 && target.length() <= 20);
    }


    /**
     * Sets list view height based on children.
     *
     * @param listView the list view
     */
    public static void setListViewHeightBasedOnChildren(ListView listView) {
        ListAdapter listAdapter = listView.getAdapter();
        if (listAdapter == null) {
            return;
        }

        int totalHeight = 0;
        for (int i = 0; i < listAdapter.getCount(); i++) {
            View listItem = listAdapter.getView(i, null, listView);
            listItem.measure(0, 0);
            totalHeight += listItem.getMeasuredHeight();
        }

        ViewGroup.LayoutParams params = listView.getLayoutParams();
        params.height = totalHeight
                + (listView.getDividerHeight() * (listAdapter.getCount() - 1));
        listView.setLayoutParams(params);
    }

    /**
     * Hide soft keyboard.
     *
     * @param activity the activity
     */
    public static void hideSoftKeyboard(Activity activity) {
        InputMethodManager inputMethodManager = (InputMethodManager) activity.getSystemService(Context.INPUT_METHOD_SERVICE);

        if (activity.getCurrentFocus() != null) {
            inputMethodManager.hideSoftInputFromWindow(activity.getCurrentFocus().getWindowToken(), 0);
        }
    }

    /**
     * Send email.
     *
     * @param context the context
     * @param To      the to
     */
    public static void SendEmail(Activity context, String To) {
        Intent emailIntent = new Intent(Intent.ACTION_SEND);
        emailIntent.setData(Uri.parse("mailto:"));
        emailIntent.setType("text/plain");
        emailIntent.putExtra(Intent.EXTRA_EMAIL, To);
        emailIntent.putExtra(Intent.EXTRA_SUBJECT, "");
        emailIntent.putExtra(Intent.EXTRA_TEXT, "");
        try {
            context.startActivity(Intent.createChooser(emailIntent, "Send mail..."));
            Log.i("Finished sending email", "");
        } catch (android.content.ActivityNotFoundException ex) {
            Toast.makeText(context,
                    "There is no email client installed.", Toast.LENGTH_SHORT).show();
        }
    }

    /**
     * Gets time stamp date.
     *
     * @param date_time the date time
     * @param format    the format
     * @return the time stamp date
     */
    public static String getTimeStampDate(String date_time, String format) {

        SimpleDateFormat formatter = new SimpleDateFormat(format,Locale.getDefault());
        formatter.setTimeZone(TimeZone.getDefault());
        Date datee;
        try {
            datee = formatter.parse(date_time);
            Log.e("", "Today is  : " + datee.getTime());
            String timestamp = "" + datee.getTime();
            if (timestamp.length() > 10) {
                timestamp = "" + Long.parseLong(timestamp) / 1000L;
            }
            return timestamp;
        } catch (ParseException pe) {
            pe.printStackTrace();
            return "";
        }

    }

    /**
     * Gets time stamp.
     *
     * @return the time stamp
     */
    public static String getTimeStamp() {

        long timestamp = (System.currentTimeMillis() / 1000L);
        String tsTemp = "" + timestamp;

        return "" + tsTemp;

    }



   /* public static boolean isUsername(CharSequence target) {
        if (target == null) {
            return false;
        } else {

            return android.util.Patterns.Con.matcher(target)
                    .matches();
        }
    }*/

    /**
     * Is online boolean.
     *
     * @param context the context
     * @return the boolean
     */
    public static boolean isOnline(Context context) {
        ConnectivityManager conMgr = (ConnectivityManager) context
                .getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo netInfo = conMgr.getActiveNetworkInfo();

        return !(netInfo == null || !netInfo.isConnected() || !netInfo.isAvailable());
    }

    /**
     * Save preferences string.
     *
     * @param context the context
     * @param key     the key
     * @param value   the value
     */
/* public static void savePreferencesString(Context context, String key, String value)
     {

         SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
         Editor editor = sharedPreferences.edit();
         editor.putString(key, value);
         editor.commit();

     }*/
    public static void savePreferencesString(Context context, String key,
                                             String value) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString(key, value);
        editor.apply();

    }

    /**
     * Save preferences serializable.
     *
     * @param context the context
     * @param key     the key
     * @param value   the value
     */
    public static void savePreferencesSerializable(Context context, String key,
                                                   Serializable value) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString(key, (String) value);
        editor.apply();

    }

    /**
     * Save preferences boolean.
     *
     * @param context the context
     * @param key     the key
     * @param value   the value
     */
    public static void savePreferencesBoolean(Context context, String key, boolean value) {

        SharedPreferences sharedPreferences = PreferenceManager.getDefaultSharedPreferences(context);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putBoolean(key, value);
        editor.apply();
    }

    /**
     * Gets preferences string.
     *
     * @param context the context
     * @param key     the key
     * @return the preferences string
     */
    public static String getPreferencesString(Context context, String key) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        return sharedPreferences.getString(key, "");

    }

    /**
     * Gets preferences.
     *
     * @param context the context
     * @param key     the key
     * @return the preferences
     */
    public static String getPreferences(Context context, String key) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        return sharedPreferences.getString(key, "");

    }

  /*  public static void removePreferences(Activity context, String key) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.remove(key);

    }*/

    /**
     * Gets preferences boolean.
     *
     * @param context the context
     * @param key     the key
     * @return the preferences boolean
     */
    public static boolean getPreferencesBoolean(Activity context, String key) {

        SharedPreferences sharedPreferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        return sharedPreferences.getBoolean(key, false);

    }


/*
    public static String getDate(Context context, String timestamp_in_string) {
        long dv = (Long.valueOf(timestamp_in_string)) * 1000;// its need to be in milisecond
        Date df = new Date(dv);
        String vv = new SimpleDateFormat("MM/dd/yyyy, hh:mm aa").format(df);
        */
/*
            String[] bits = str.split("-");
			 String mnth = bits[0];

		 *//*


        return vv;
    }
*/

    /**
     * Gets time.
     *
     * @param timestamp_in_string the timestamp in string
     * @return the time
     */
    public static String getTime(String timestamp_in_string) {
        long dv = Long.valueOf(timestamp_in_string) * 1000;// its need to be in milisecond
        Calendar cal = Calendar.getInstance(Locale.ENGLISH);
        cal.setTimeInMillis(dv);
        return DateFormat.format("hh:mm:ss", cal).toString();

    }

    /**
     * Is date today boolean.
     *
     * @param milliSeconds the milli seconds
     * @return the boolean
     */
    public static boolean isDateToday(long milliSeconds) {
        Calendar calendar = Calendar.getInstance();
        calendar.setTimeInMillis(milliSeconds);
        Date getDate = calendar.getTime();
        calendar.setTimeInMillis(System.currentTimeMillis());
        calendar.set(Calendar.HOUR_OF_DAY, 0);
        calendar.set(Calendar.MINUTE, 0);
        calendar.set(Calendar.SECOND, 0);

        Date startDate = calendar.getTime();

        return getDate.compareTo(startDate) > 0;

    }

    /**
     * Show alert title.
     *
     * @param title   the title
     * @param message the message
     * @param context the context
     */
    public static void showAlertTitle(String title, String message,
                                      final Context context) {

        AlertDialog.Builder builder = new AlertDialog.Builder(context);
        builder.setMessage(message).setCancelable(false).setTitle(title)
                .setPositiveButton("OK", new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {

                    }
                });

        try {
            builder.show();
        } catch (Exception e) {
            e.printStackTrace();
        }

    }


    /**
     * Is valid mobile boolean.
     *
     * @param phone the phone
     * @return the boolean
     */
    public static boolean isValidMobile(String phone)
    {
        return Patterns.PHONE.matcher(phone).matches();
    }


    /**
     * Gets date and time from ts date.
     *
     * @param timeStamp the time stamp
     * @return the date and time from ts date
     */
    public static String getDateAndTimeFromTSDate(String timeStamp) {
        if (timeStamp.length() > 0) {
            return new SimpleDateFormat("MM-dd-yyyy, hh:mm a",Locale.getDefault())
                    .format(new Date((Long.valueOf(timeStamp) * 1000)));
        } else {
            return "";
        }
    }

    public static String getDateFromTSDate(String timeStamp) {
        if (timeStamp.length() > 0) {
            return new SimpleDateFormat("EEE, dd MMM yyyy",Locale.getDefault())
                    .format(new Date((Long.valueOf(timeStamp) * 1000)));
        } else {
            return "";
        }
    }

    /**
     * Gets year from ts date.
     *
     * @param timeStamp the time stamp
     * @return the year from ts date
     */
    public static String getYearFromTSDate(String timeStamp) {
        if (timeStamp.length() > 0) {
            return new SimpleDateFormat("yyyy",Locale.getDefault())
                    .format(new Date((Long.valueOf(timeStamp) /** 1000*/)));
        } else {
            return "";
        }
    }

    /**
     * Gets hours from millis.
     *
     * @param milliseconds the milliseconds
     * @return the hours from millis
     */
    public static String getHoursFromMillis(long milliseconds) {
        return "" + (int) ((milliseconds / (1000 * 60 * 60)) % 24);
    }

    /**
     * Gets bit map from image u rl.
     *
     * @param imagepath the imagepath
     * @param activity  the activity
     * @return the bit map from image u rl
     */
    public static Bitmap getBitMapFromImageURl(String imagepath, Activity activity) {

        Bitmap bitmapFromMapActivity = null;
        Bitmap bitmapImage = null;
        try {

            File file = new File(imagepath);
            // We need to recyle unused bitmaps
            bitmapImage = reduceImageSize(file, activity);
            int exifOrientation = 0;
            try {
                ExifInterface exif = new ExifInterface(imagepath);
                exifOrientation = exif.getAttributeInt(ExifInterface.TAG_ORIENTATION, ExifInterface.ORIENTATION_NORMAL);
            } catch (IOException e) {
                e.printStackTrace();
            }

            int rotate = 0;

            switch (exifOrientation) {
                case ExifInterface.ORIENTATION_ROTATE_90:
                    rotate = 90;
                    break;

                case ExifInterface.ORIENTATION_ROTATE_180:
                    rotate = 180;
                    break;

                case ExifInterface.ORIENTATION_ROTATE_270:
                    rotate = 270;
                    break;
            }

            if (rotate != 0) {
                int w = bitmapImage.getWidth();
                int h = bitmapImage.getHeight();

                // Setting pre rotate
                Matrix mtx = new Matrix();
                mtx.preRotate(rotate);

                // Rotating Bitmap & convert to ARGB_8888, required by
                // tess

                Bitmap myBitmap = Bitmap.createBitmap(bitmapImage, 0, 0, w, h,
                        mtx, false);
                bitmapFromMapActivity = myBitmap;
            } else {
                int SCALED_PHOTO_WIDTH = 150;
                int SCALED_PHOTO_HIGHT = 200;
                bitmapFromMapActivity = Bitmap.createScaledBitmap(bitmapImage,
                        SCALED_PHOTO_WIDTH, SCALED_PHOTO_HIGHT, true);
            }
        } catch (Exception e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }

        return bitmapFromMapActivity;

    }

    private static Bitmap reduceImageSize(File f, Context context) {

        Bitmap m = null;
        try {

            BitmapFactory.Options o = new BitmapFactory.Options();
            o.inJustDecodeBounds = true;
            BitmapFactory.decodeStream(new FileInputStream(f), null, o);

            final int REQUIRED_SIZE = 150;

            int width_tmp = o.outWidth, height_tmp = o.outHeight;

            int scale = 1;
            while (true) {
                if (width_tmp / 2 < REQUIRED_SIZE
                        || height_tmp / 2 < REQUIRED_SIZE)
                    break;
                width_tmp /= 2;
                height_tmp /= 2;
                scale *= 2;
            }

            // Decode with inSampleSize
            BitmapFactory.Options o2 = new BitmapFactory.Options();
            o2.inSampleSize = scale;
            o2.inPreferredConfig = Bitmap.Config.ARGB_8888;
            m = BitmapFactory.decodeStream(new FileInputStream(f), null, o2);
        } catch (FileNotFoundException e) {
            // Toast.makeText(context,
            // "Image File not found in your phone. Please select another image.",
            // Toast.LENGTH_LONG).show();
        }
        return m;
    }




    /**
     * Check email id boolean.
     *
     * @param emailId the email id
     * @return the boolean
     */
    public static boolean checkEmailId(String emailId) {
        return Patterns.EMAIL_ADDRESS.matcher(emailId).matches();
    }


    /**
     * Sets fragment.
     *
     * @param fragment    the fragment
     * @param removeStack the remove stack
     * @param activity    the activity
     * @param mContainer  the m container
     * @param tag         the tag
     */
    public static void setFragment(Fragment fragment, boolean removeStack, FragmentActivity activity, FrameLayout mContainer, String tag) {
        FragmentManager fragmentManager = activity.getSupportFragmentManager();
        FragmentTransaction ftTransaction = fragmentManager.beginTransaction();
        if (removeStack) {
            fragmentManager.popBackStack(null, FragmentManager.POP_BACK_STACK_INCLUSIVE);
            if (tag != null)
                ftTransaction.replace(mContainer.getId(), fragment, tag);
            else
                ftTransaction.replace(mContainer.getId(), fragment);
        } else {
            if (tag != null)
                ftTransaction.replace(mContainer.getId(), fragment, tag);
            else
                ftTransaction.replace(mContainer.getId(), fragment);

                ftTransaction.addToBackStack(null);

        }
        ftTransaction.commit();
    }


    /**
     * This method is used for Enable View
     *
     * @param view the view
     */
    public static void setEnableState(View view) {
        view.setAlpha(ALPHA_DARK);
        view.setEnabled(true);
        view.setClickable(true);
    }

    /**
     * This method is used for Disable View
     *
     * @param view the view
     */
    public static void setDisableState(View view) {
        view.setAlpha(ALPHA_LIGHT);
        view.setEnabled(false);
        view.setClickable(false);
    }

    /**
     * Print log.
     *
     * @param tag the tag
     * @param msg the msg
     */
    public static void printLog(String tag, String msg) {
        Log.e(tag, msg);
    }

    /**
     * Show progress dialog.
     *
     * @param context the context
     */
    public static void showProgressDialog(Context context) {
        if (context != null) {

            dialogProgress = new ProgressDialog(context);
            dialogProgress.getWindow().setLayout(LinearLayout.LayoutParams.WRAP_CONTENT, LinearLayout.LayoutParams.WRAP_CONTENT);
            //   dialogProgress.setIndeterminateDrawable(context.getResources().getDrawable(R.drawable.my_progress_indeterminate));
            dialogProgress.setMessage(context.getResources().getString(R.string.loading));
            if (!dialogProgress.isShowing()) {
                try {
                    dialogProgress.show();
                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
            dialogProgress.setCancelable(false);

        }
    }

    /**
     * Dis miss progress dialog.
     *
     * @param mContext the m context
     */
    public static void disMissProgressDialog(Context mContext) {
        if (dialogProgress != null) {
            dialogProgress.dismiss();
            dialogProgress = null;
        }
    }

    /**
     * Clear preference.
     *
     * @param context the context
     * @param keyName the key name
     */
    public static void clearPreference(Context context, String keyName) {
        SharedPreferences preferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        if (preferences.contains(keyName)) {
            SharedPreferences.Editor editor = preferences.edit();
            editor.remove(keyName);
            editor.apply();
        }


    }


    /**
     * Save string to preference.
     *
     * @param context  the context
     * @param keyName  the key name
     * @param keyValue the key value
     */
    public static void saveStringToPreference(Context context, String keyName,
                                              String keyValue) {
        SharedPreferences preferences = PreferenceManager
                .getDefaultSharedPreferences(context);
        SharedPreferences.Editor editor = preferences.edit();
        editor.putString(keyName, keyValue);
        editor.apply();
    }

    /**
     * Check permission camera boolean.
     *
     * @param context the context
     * @return the boolean
     */
    public static boolean checkPermissionCamera(Activity context) {
        int result = ContextCompat.checkSelfPermission(context, Manifest.permission.CAMERA);
        return result == PackageManager.PERMISSION_GRANTED;
    }

    /**
     * Request permission camera.
     *
     * @param activity the activity
     */
    public static void requestPermissionCamera(Activity activity) {
        if (ActivityCompat.shouldShowRequestPermissionRationale(activity, Manifest.permission.CAMERA)) {
            ActivityCompat.requestPermissions(activity, new String[]{Manifest.permission.CAMERA}, AppConstant.PERMISSION_REQUEST_CAMERA_CODE);
        } else {
            ActivityCompat.requestPermissions(activity, new String[]{Manifest.permission.CAMERA}, AppConstant.PERMISSION_REQUEST_CAMERA_CODE);
        }
    }


    /**
     * Check permission storage boolean.
     *
     * @param context the context
     * @return the boolean
     */
    public static boolean checkPermissionStorage(Activity context) {
        int result = ContextCompat.checkSelfPermission(context, Manifest.permission.WRITE_EXTERNAL_STORAGE);
        int result1 = ContextCompat.checkSelfPermission(context, Manifest.permission.READ_EXTERNAL_STORAGE);
        return result == PackageManager.PERMISSION_GRANTED && result1 == PackageManager.PERMISSION_GRANTED;
    }

    /**
     * Request permission storage.
     *
     * @param activity the activity
     */
    public static void requestPermissionStorage(Activity activity) {
        if (ActivityCompat.shouldShowRequestPermissionRationale(activity, Manifest.permission.WRITE_EXTERNAL_STORAGE) || ActivityCompat.shouldShowRequestPermissionRationale(activity, Manifest.permission.READ_EXTERNAL_STORAGE)) {
            ActivityCompat.requestPermissions(activity, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE}, AppConstant.PERMISSION_REQUEST_STORAGE_CODE);
            ActivityCompat.requestPermissions(activity, new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},
                    AppConstant.PERMISSION_REQUEST_STORAGE_CODE);
            Log.e(TAG, ":::: WRITE_EXTERNAL_STORAGE: if ::::::::");

        } else {
            Log.e(TAG, ":: WRITE_EXTERNAL_STORAGE::: else ::::::::");

            ActivityCompat.requestPermissions(activity, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE}, AppConstant.PERMISSION_REQUEST_STORAGE_CODE);
            ActivityCompat.requestPermissions(activity, new String[]{Manifest.permission.READ_EXTERNAL_STORAGE}, AppConstant.PERMISSION_REQUEST_STORAGE_CODE);
        }
    }



    /**
     * Gets time am pm.
     *
     * @param timestamp_in_string the timestamp in string
     * @return the time am pm
     */
    public static String getTimeAmPm(String timestamp_in_string) {
        long dv = Long.valueOf(timestamp_in_string) * 1000;// its need to be in milisecond
        Calendar cal = Calendar.getInstance(Locale.ENGLISH);
        cal.setTimeInMillis(dv);
        String date = DateFormat.format("hh:mm aa", cal).toString();
        return date;

    }



    /**
     * Remove decimal string.
     *
     * @param value the value
     * @return the string
     */
    public static String removeDecimal(Double  value) {
        DecimalFormat decimalFormat=new DecimalFormat("#.#");
        System.out.println(decimalFormat.format(value)); //prints 2

        return  decimalFormat.format(value);

    }

    /**
     * Check all permissions boolean.
     *
     * @param mContext the m context
     * @return the boolean
     */
    public static boolean checkAllPermissions(Context mContext) {
        int result = ContextCompat.checkSelfPermission(mContext, Manifest.permission.WRITE_EXTERNAL_STORAGE);
        int result1 = ContextCompat.checkSelfPermission(mContext, Manifest.permission.READ_EXTERNAL_STORAGE);
        //int result1 = ContextCompat.checkSelfPermission(mContext, Manifest.permission.CAMERA);
        //int result = ContextCompat.checkSelfPermission(mContext, Manifest.permission.ACCESS_COARSE_LOCATION);
        //int result1 = ContextCompat.checkSelfPermission(mContext, Manifest.permission.ACCESS_FINE_LOCATION);

        return result == PackageManager.PERMISSION_GRANTED && result1 == PackageManager.PERMISSION_GRANTED
                /*&& result2 == PackageManager.PERMISSION_GRANTED && result3 == PackageManager.PERMISSION_GRANTED*/;

    }

    /**
     * Request all permissions.
     *
     * @param activity                              the activity
     * @param REQUEST_CODE_ASK_MULTIPLE_PERMISSIONS the request code ask multiple permissions
     */
    public static void requestAllPermissions(Activity activity, int REQUEST_CODE_ASK_MULTIPLE_PERMISSIONS) {
        if (ActivityCompat.shouldShowRequestPermissionRationale(activity, Manifest.permission.WRITE_EXTERNAL_STORAGE)
                || ActivityCompat.shouldShowRequestPermissionRationale(activity, Manifest.permission.READ_EXTERNAL_STORAGE)
                /* ActivityCompat.shouldShowRequestPermissionRationale(activity, Manifest.permission.ACCESS_COARSE_LOCATION)
                || ActivityCompat.shouldShowRequestPermissionRationale(activity, Manifest.permission.ACCESS_FINE_LOCATION)*/) {

            ActivityCompat.requestPermissions(activity, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE, Manifest.permission.READ_EXTERNAL_STORAGE
                    /*Manifest.permission.CAMERA, Manifest.permission.ACCESS_COARSE_LOCATION,
                    Manifest.permission.ACCESS_FINE_LOCATION*/}, REQUEST_CODE_ASK_MULTIPLE_PERMISSIONS);
        } else {
            ActivityCompat.requestPermissions(activity, new String[]{Manifest.permission.WRITE_EXTERNAL_STORAGE, Manifest.permission.READ_EXTERNAL_STORAGE
                    /*Manifest.permission.CAMERA, Manifest.permission.ACCESS_COARSE_LOCATION,
                    Manifest.permission.ACCESS_FINE_LOCATION*/}, REQUEST_CODE_ASK_MULTIPLE_PERMISSIONS);

        }
    }

    /**
     * Encode tobase 64 string.
     *
     * @param image the image
     * @return the string
     */
    public static String encodeTobase64(Bitmap image) {
        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        image.compress(Bitmap.CompressFormat.JPEG, 100, baos);
        byte[] b = baos.toByteArray();
        String imageEncoded = Base64.encodeToString(b,Base64.DEFAULT);

        Log.e("LOOK", imageEncoded);
        return imageEncoded;
    }

    /**
     * Gets path.
     *
     * @param context the context
     * @param uri     the uri
     * @return the path
     */
    public static String getPath(Activity context,final Uri uri) {

        final boolean isKitKat = Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT;

        // DocumentProvider
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT) {
            if (isKitKat && DocumentsContract.isDocumentUri(context, uri)) {
                // ExternalStorageProvider
                if (isExternalStorageDocument(uri)) {
                    final String docId = DocumentsContract.getDocumentId(uri);
                    final String[] split = docId.split(":");
                    final String type = split[0];

                    if ("primary".equalsIgnoreCase(type)) {
                        return Environment.getExternalStorageDirectory() + "/" + split[1];
                    }
                }
                // DownloadsProvider
                else if (isDownloadsDocument(uri)) {

                    final String id = DocumentsContract.getDocumentId(uri);
                    final Uri contentUri = ContentUris.withAppendedId(
                            Uri.parse("content://downloads/public_downloads"), Long.valueOf(id));

                    return getDataColumn(context, contentUri, null, null);
                }
                // MediaProvider
                else if (isMediaDocument(uri)) {
                    final String docId = DocumentsContract.getDocumentId(uri);
                    final String[] split = docId.split(":");
                    final String type = split[0];

                    Uri contentUri = null;
                    if ("image".equals(type)) {
                        contentUri = MediaStore.Images.Media.EXTERNAL_CONTENT_URI;
                    } else if ("video".equals(type)) {
                        contentUri = MediaStore.Video.Media.EXTERNAL_CONTENT_URI;
                    } else if ("audio".equals(type)) {
                        contentUri = MediaStore.Audio.Media.EXTERNAL_CONTENT_URI;
                    }
                    final String selection = "_id=?";
                    final String[] selectionArgs = new String[] {
                            split[1]
                    };

                    return getDataColumn(context, contentUri, selection, selectionArgs);
                }
            }
            // MediaStore (and general)
            else if ("content".equalsIgnoreCase(uri.getScheme())) {
                return getDataColumn(context, uri, null, null);
            }
            // File
            else if ("file".equalsIgnoreCase(uri.getScheme())) {
                return uri.getPath();
            }
        }

        return null;
    }


    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is ExternalStorageProvider.
     */
    private static boolean isExternalStorageDocument(Uri uri) {
        return "com.android.externalstorage.documents".equals(uri.getAuthority());
    }

    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is DownloadsProvider.
     */
    private static boolean isDownloadsDocument(Uri uri) {
        return "com.android.providers.downloads.documents".equals(uri.getAuthority());
    }

    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is MediaProvider.
     */
    private static boolean isMediaDocument(Uri uri) {
        return "com.android.providers.media.documents".equals(uri.getAuthority());
    }

    /**
     * Get the value of the data column for this Uri. This is useful for
     * MediaStore Uris, and other file-based ContentProviders.
     *
     * @param context The context.
     * @param uri The Uri to query.
     * @param selection (Optional) Filter used in the query.
     * @param selectionArgs (Optional) Selection arguments used in the query.
     * @return The value of the _data column, which is typically a file path.
     */
    private static String getDataColumn(Context context, Uri uri, String selection,
                                        String[] selectionArgs) {

        Cursor cursor = null;
        final String column = "_data";
        final String[] projection = {
                column
        };
        try {
            cursor = context.getContentResolver().query(uri, projection, selection, selectionArgs,
                    null);
            if (cursor != null && cursor.moveToFirst()) {
                final int column_index = cursor.getColumnIndexOrThrow(column);
                return cursor.getString(column_index);
            }
        } finally {
            if (cursor != null)
                cursor.close();
        }
        return null;
    }


    /**
     * Show alert ok.
     *
     * @param message the message
     * @param context the context
     */
    public static void showAlertOk(String message, Context context) {
        android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(context);
        builder.setMessage(message)
                .setCancelable(false)
                .setPositiveButton("OK",
                        new DialogInterface.OnClickListener() {
                            @Override
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.dismiss();
                            }
                        });

        try {
            builder.show();
        } catch (Exception e) {
            e.printStackTrace();
        }
    }


    /**
     * Sets bold.
     *
     * @param context the context
     * @return the bold
     */
    public static Typeface setBold(Context context) {
        return Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Bold.ttf");
    }

    /**
     * Sets regular.
     *
     * @param context the context
     * @return the regular
     */
    public static Typeface setRegular(Context context) {
        return Typeface.createFromAsset(context.getAssets(), "fonts/Roboto-Regular.ttf");
    }


    public static void requestPermissionGPS(Activity context) {
        if (ActivityCompat.shouldShowRequestPermissionRationale(context, Manifest.permission.ACCESS_FINE_LOCATION)) {
            ActivityCompat.requestPermissions(context, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, AppConstant.PERMISSION_REQUEST_GPS_CODE);
        } else {
            ActivityCompat.requestPermissions(context, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, AppConstant.PERMISSION_REQUEST_GPS_CODE);
        }
    }

    public static boolean checkPermissionGPS(Activity context) {
        int result = ContextCompat.checkSelfPermission(context, Manifest.permission.ACCESS_FINE_LOCATION);
        return result == PackageManager.PERMISSION_GRANTED;
    }

    public static  int getDeviceWidth(Activity mContext)
    {
        Display mDisplay = mContext.getWindowManager().getDefaultDisplay();
        final int width  = mDisplay.getWidth();

        return  width;
    }

    public  static int getDeviceHeight(Activity mContext)
    {
        Display mDisplay = mContext.getWindowManager().getDefaultDisplay();
        final int width  = mDisplay.getHeight();
        return  width;
    }



}





