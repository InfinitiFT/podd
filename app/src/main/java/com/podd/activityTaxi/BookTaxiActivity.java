package com.podd.activityTaxi;

import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.Locale;

/**
 * The type Book taxi activity.
 */
public class BookTaxiActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private Spinner spSelectAirport;
    private Spinner spSelectTime;
    private Spinner spSelectPeople;
    private Spinner spSelectAdditionalRequirement;
    private TextView tvBookNow;
    private TextView tvSelectfromCalender;
    private TextView tvTomorrow;
    private TextView tvToday;
    private EditText etLeavingAddress;
    private EditText etGoingAddress;
    private final String[]airportArray={"Select Airport","Newyork","Others"};
    private final String[]timeArray={"Select Time","10 AM","10:30 AM"};
    private final String[]numberOfPeopleArray={"Select Nember of People","1","2","3"};
    private final String[]requirementsArray={"Select Additional Requirements","AC","Others"};
    private TextView tvBack;
    private String date;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_book_taxi);
        context=BookTaxiActivity.this;
        getIds();
        selectAdditionalRequirementsAdapter();
        selectAirportAdapter();
        selectNumberOfPeopleAdapter();
        selectTimeAdapter();
        setListeners();
    }

    private void setListeners() {
        tvBookNow.setOnClickListener(this);
        tvSelectfromCalender.setOnClickListener(this);
        tvToday.setOnClickListener(this);
        tvTomorrow.setOnClickListener(this);


    }

    private void getIds() {
        spSelectAirport= (Spinner) findViewById(R.id.spSelectAirport);
        spSelectAdditionalRequirement= (Spinner) findViewById(R.id.spSelectAdditionalRequirement);
        spSelectPeople= (Spinner) findViewById(R.id.spSelectPeople);
        spSelectTime= (Spinner) findViewById(R.id.spSelectTime);
        etGoingAddress= (EditText) findViewById(R.id.etGoingAddress);
        etLeavingAddress= (EditText) findViewById(R.id.etLeavingAddress);
        TextView tvLeavingFrom = (TextView) findViewById(R.id.tvLeavingFrom);
        TextView tvGoingTo = (TextView) findViewById(R.id.tvGoingTo);
        TextView tvDate = (TextView) findViewById(R.id.tvDate);
        tvToday= (TextView) findViewById(R.id.tvToday);
        tvTomorrow= (TextView) findViewById(R.id.tvTomorrow);
        tvSelectfromCalender= (TextView) findViewById(R.id.tvSelectFromCalender);
        TextView tvTime = (TextView) findViewById(R.id.tvTime);
        TextView tvSelectPeople = (TextView) findViewById(R.id.tvSelectPeople);
        TextView tvAdditionalRequirements = (TextView) findViewById(R.id.tvAdditionalRequirements);
        tvBookNow= (TextView) findViewById(R.id.tvBookNow);
        TextView tvBookTaxi = (TextView) findViewById(R.id.tvBookTaxi);
        LinearLayout llInner = (LinearLayout) findViewById(R.id.llInner);


        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowHomeEnabled(true);
            getSupportActionBar().setTitle("");
        }
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });
    }


    private void selectAirportAdapter() {
        ArrayAdapter<String> adapter=new ArrayAdapter<String>(context,R.layout.row_textview_spinner_type,airportArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectAirport.setAdapter(adapter);
    }
    private void selectTimeAdapter() {
        ArrayAdapter<String> adapter=new ArrayAdapter<String>(context,R.layout.row_textview_spinner_type,timeArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectTime.setAdapter(adapter);
    }
    private void selectNumberOfPeopleAdapter() {
        ArrayAdapter<String> adapter=new ArrayAdapter<String>(context,R.layout.row_textview_spinner_type,numberOfPeopleArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectPeople.setAdapter(adapter);
    }
    private void selectAdditionalRequirementsAdapter() {
        ArrayAdapter<String> adapter=new ArrayAdapter<String>(context,R.layout.row_textview_spinner_type,requirementsArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectAdditionalRequirement.setAdapter(adapter);
    }


    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookNow:
                if (isValid()) {
                    Intent intent=new Intent(context,TaxiBookingSummaryActivity.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    startActivity(intent);
                }
                break;
            case R.id.tvSelectFromCalender:
                tvToday.setText(R.string.today);
                tvTomorrow.setText(R.string.tomorrow);
                pickDate();
                break;
            case R.id.tvTomorrow:
                tvToday.setText(R.string.today);
                tvSelectfromCalender.setText(R.string.select_from_calender);

                 /*  getting tomorrow date  */

                String currentDateString = DateFormat.getDateInstance().format(new Date());
                date = DateFormat.getDateInstance().format(System.currentTimeMillis()+(24*3600000));
                tvTomorrow.setText(date);
                break;
            case R.id.tvToday:
                tvSelectfromCalender.setText(R.string.select_from_calender);
                tvTomorrow.setText(R.string.tomorrow);

                /*  getting current date  */

                currentDateString = DateFormat.getDateInstance().format(new Date());
                tvToday.setText(currentDateString);
                break;



        }
    }

    private boolean isValid(){
        if(etLeavingAddress.getText().toString().isEmpty()){
            Toast.makeText(context,R.string.please_enter_leaving_address,Toast.LENGTH_SHORT).show();
            etLeavingAddress.requestFocus();
            return false;
        }
        else if (etGoingAddress.getText().toString().isEmpty()){
            Toast.makeText(context,R.string.please_enter_going_address,Toast.LENGTH_SHORT).show();
            etGoingAddress.requestFocus();
            return false;
        }

        return true;
    }




    private void pickDate() {
        final Calendar calendar = Calendar.getInstance();
        int cYear = calendar.get(Calendar.YEAR);
        final int cMonth = calendar.get(Calendar.MONTH);
        final int cDay = calendar.get(Calendar.DAY_OF_MONTH);

        DatePickerDialog dpd = new DatePickerDialog(context, new DatePickerDialog.OnDateSetListener() {

            @Override
            public void onDateSet(DatePicker view, int year, int monthOfYear, int dayOfMonth) {
                calendar.set(year, monthOfYear, dayOfMonth);
                SimpleDateFormat simpleDateFormat = new SimpleDateFormat("dd/MM/yyyy", Locale.getDefault());
                date = simpleDateFormat.format(calendar.getTime());
                //selected = Long.parseLong(String.valueOf((CommonUtils.getTimeStampDate(date, "dd/MM/yyyy"))));

                tvSelectfromCalender.setText(date);

               /* tvSelectTimeValue.setText(R.string.select_time);*/

                CommonUtils.savePreferenceInt(context, AppConstant.YEAR, year);
                CommonUtils.savePreferenceInt(context, AppConstant.MONTH, monthOfYear);
                CommonUtils.savePreferenceInt(context, AppConstant.DATE, dayOfMonth);
            }
        }, cYear, cMonth, cDay);
        DatePicker dp = dpd.getDatePicker();
        if (date != null) {
            dpd.getDatePicker().updateDate(CommonUtils.getPreferencesInt(context, AppConstant.YEAR),
                    CommonUtils.getPreferencesInt(context, AppConstant.MONTH),
                    CommonUtils.getPreferencesInt(context, AppConstant.DATE));
        } else {
            dp.setMaxDate(Calendar.getInstance().getTimeInMillis());
        }
        dpd.show();
        dpd.getDatePicker().setMinDate(System.currentTimeMillis());
        dpd.getDatePicker().setMaxDate(System.nanoTime());
        dpd.setCancelable(true);
    }
}
