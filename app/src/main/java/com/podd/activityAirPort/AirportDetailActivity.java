package com.podd.activityAirPort;

import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.CheckBox;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.activityRestaurant.SearchableListDialog;
import com.podd.activityRestaurant.SearchableLocationListDialog;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;

import java.text.SimpleDateFormat;
import java.util.Arrays;
import java.util.Calendar;
import java.util.Locale;

/**
 * Created by Raj Kumar on 3/7/2017
 * for Mobiloitte
 */

public class AirportDetailActivity extends AppCompatActivity implements View.OnClickListener,SearchableListDialog.SearchableItem ,SearchableLocationListDialog.SearchableItem{
    private Context mContext=AirportDetailActivity.this;
    private final String TAG = AirportDetailActivity.class.getSimpleName();
    private TextView tvMsg,tvDate,tvBagNumber,tvTime,tvSubmit,tvTimeFormate,tvHeader;
    private EditText etName,etPickUp,etSelectDelivery,etPhoneNumber;
    private CheckBox cbTermsConditions;
    private String date;
    private SearchableListDialog _searchableListDialog;
    private final String[] numberOfBagArray = {/*"Number of bag",*/ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10"};
    private final String[] timeSlot = {/*"Number of bag",*/ "(9AM to 5PM)", "(5PM to 1AM)", "(1AM to 9AM)"};
    private String selectedItem = "";
    private LinearLayout llTime;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_airport_detail);
        getID();
        setFont();
        setListeners();
    }
    private void getID() {
        tvHeader=(TextView)findViewById(R.id.tvHeader);
        tvMsg=(TextView)findViewById(R.id.tvMsg);
        etName=(EditText)findViewById(R.id.etName);
        tvDate=(TextView)findViewById(R.id.tvDate);
        tvBagNumber=(TextView)findViewById(R.id.tvBagNumber);
        etPickUp=(EditText)findViewById(R.id.etPickUp);
        etSelectDelivery=(EditText)findViewById(R.id.etSelectDelivery);
        etPhoneNumber=(EditText)findViewById(R.id.etPhoneNumber);
        tvTime=(TextView)findViewById(R.id.tvTime);
        tvSubmit=(TextView)findViewById(R.id.tvSubmit);
        tvTimeFormate=(TextView)findViewById(R.id.tvTimeFormate);
        cbTermsConditions=(CheckBox)findViewById(R.id.cbTermsConditions);
        llTime=(LinearLayout)findViewById(R.id.llTime);

    }
    private void setFont() {
        Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");

        tvHeader.setTypeface(typefaceBold);
        tvMsg.setTypeface(typeface);
        etName.setTypeface(typeface);
        tvDate.setTypeface(typeface);
        tvBagNumber.setTypeface(typeface);
        etPickUp.setTypeface(typeface);
        etSelectDelivery.setTypeface(typeface);
        etPhoneNumber.setTypeface(typeface);
        tvTime.setTypeface(typeface);
        cbTermsConditions.setTypeface(typeface);
        tvTimeFormate.setTypeface(typeface);
    }
    private void setListeners() {
        tvDate.setOnClickListener(this);
        tvBagNumber.setOnClickListener(this);
        tvSubmit.setOnClickListener(this);
        tvTime.setOnClickListener(this);
        llTime.setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvDate:
                pickDate();
                break;
            case R.id.tvBagNumber:
                BagNumber();
                break;
            case R.id.llTime:
                timeFormate();
                break;
            case R.id.tvSubmit:
               if(isValid()){
                   startActivity(new Intent(mContext,AirportSummeryActivity.class));
               }
                break;
        }

    }
    private boolean isValid() {
        if (etName.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please enetr name.", Toast.LENGTH_LONG).show();
            return false;
        } else if (tvDate.getText().toString().trim().matches(getString(R.string.date_of_travel))) {
            Toast.makeText(mContext, R.string.please_select_a_valid_time, Toast.LENGTH_LONG).show();
            return false;
        } else if (tvBagNumber.getText().toString().trim().matches(getString(R.string.number_of_bags))) {
            Toast.makeText(mContext, R.string.please_select_number_of_bag, Toast.LENGTH_LONG).show();
            return false;
        } else if (etPickUp.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please enter pick up location.", Toast.LENGTH_LONG).show();
            return false;
        } else if (etSelectDelivery.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please enter delivery airport.", Toast.LENGTH_LONG).show();
            return false;
        }else if (etPhoneNumber.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please enter telephone number.", Toast.LENGTH_LONG).show();
            return false;
        }else if (tvTime.getText().toString().trim().equalsIgnoreCase("")) {
            Toast.makeText(mContext, "Please select time.", Toast.LENGTH_LONG).show();
            return false;
        }else if(!cbTermsConditions.isChecked()){
            Toast.makeText(mContext, R.string.privacy_policy_error_msg, Toast.LENGTH_LONG).show();
            return false;
        }

        return true;

    }

    private void BagNumber() {
        _searchableListDialog = SearchableListDialog.newInstance(Arrays.asList(numberOfBagArray));
        selectedItem = "number_of_bag";
        _searchableListDialog.setOnSearchableItemClickListener(AirportDetailActivity.this);
        _searchableListDialog.show(getFragmentManager(), TAG);
        _searchableListDialog.setTitle(getString(R.string.select));
    } private void timeFormate() {
        _searchableListDialog = SearchableListDialog.newInstance(Arrays.asList(timeSlot));
        selectedItem = "time_formate";
        _searchableListDialog.setOnSearchableItemClickListener(AirportDetailActivity.this);
        _searchableListDialog.show(getFragmentManager(), TAG);
        _searchableListDialog.setTitle(getString(R.string.select));
    }


    private void pickDate() {
        final Calendar calendar = Calendar.getInstance();
        int cYear = calendar.get(Calendar.YEAR);
        final int cMonth = calendar.get(Calendar.MONTH);
        final int cDay = calendar.get(Calendar.DAY_OF_MONTH);

        DatePickerDialog dpd = new DatePickerDialog(mContext, new DatePickerDialog.OnDateSetListener() {

            @Override
            public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                calendar.set(year, monthOfYear, dayOfMonth);
                SimpleDateFormat simpleDateFormat = new SimpleDateFormat("dd-MM-yyyy", Locale.getDefault());
                date = simpleDateFormat.format(calendar.getTime());
                //selected = Long.parseLong(String.valueOf((CommonUtils.getTimeStampDate(date, "dd/MM/yyyy"))));

                tvDate.setText(date);


              /*  CommonUtils.savePreferenceInt(mContext, AppConstant.YEAR, year);
                CommonUtils.savePreferenceInt(mContext, AppConstant.MONTH, monthOfYear);
                CommonUtils.savePreferenceInt(mContext, AppConstant.DATE, dayOfMonth);*/
            }
        }, cYear, cMonth, cDay);
        DatePicker dp = dpd.getDatePicker();
        if (date != null) {
            dpd.getDatePicker().updateDate(CommonUtils.getPreferencesInt(mContext, AppConstant.YEAR), CommonUtils.getPreferencesInt(mContext, AppConstant.MONTH), CommonUtils.getPreferencesInt(mContext, AppConstant.DATE));
        } else {
            dp.setMaxDate(Calendar.getInstance().getTimeInMillis());
        }
        dpd.show();
        dpd.getDatePicker().setMinDate(System.currentTimeMillis()-1000);
        dpd.getDatePicker().setMaxDate(System.nanoTime());
        dpd.setCancelable(true);
    }
    @Override
    public void onSearchableItemClicked(Object item, int position) {

        switch (selectedItem) {

            case "number_of_bag":
                tvBagNumber.setText(item.toString().trim());
                tvBagNumber.setText(tvBagNumber.getText().toString().trim());
                break;
            case "time_formate":
                tvTime.setText(item.toString().trim());
                tvTime.setText(tvTime.getText().toString().trim());
                tvTimeFormate.setVisibility(View.GONE);
                break;
        }
    }
}
