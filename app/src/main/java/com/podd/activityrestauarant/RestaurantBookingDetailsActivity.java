package com.podd.activityrestauarant;

import android.app.DatePickerDialog;
import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.DatePicker;
import android.widget.Spinner;
import android.widget.TextView;
import com.podd.R;
import com.podd.adapter.RestaurantsAdapter;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;

import java.text.SimpleDateFormat;
import java.util.Calendar;

/**
 * The type Restraunt booking details activity.
 */
public class RestaurantBookingDetailsActivity extends AppCompatActivity implements View.OnClickListener, AdapterView.OnItemSelectedListener {
    private Context context;
    private RecyclerView rvRestaurants;
    private TextView tvBookNow;
    private Intent intent;
    private Spinner spSelectTime;
    private Spinner spSelectPeople;
    private TextView tvSelectfromCalender;
    private TextView tvRestauarntName;
    private TextView tvDate;
    private TextView tvToday;
    private TextView tvTomorrow;
    private TextView tvTime;
    private TextView tvBookingSummary;
    private TextView tvDateBooked;
    private TextView tvTimeBooked;
    private TextView tvNoOfPersons;

    private final String[]timeArray={"Select Time","10 AM","10:30 AM"};
    private final String[]numberOfPeopleArray={"Number of People","1","2","3"};
    private String date;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_restraunt_booking_details);
        context=RestaurantBookingDetailsActivity.this;
        getIds();
        setListeners();
        selectTimeAdapter();
        selectNumberOfPeopleAdapter();
        setAdapter();
    }

    private void getIds() {
        rvRestaurants= (RecyclerView) findViewById(R.id.rvRestaurants);
        tvBookNow= (TextView) findViewById(R.id.tvBookNow);
        tvSelectfromCalender= (TextView) findViewById(R.id.tvSelectfromCalender);
        spSelectTime= (Spinner) findViewById(R.id.spSelectTime);
        spSelectPeople= (Spinner) findViewById(R.id.spSelectPeople);
        tvRestauarntName= (TextView) findViewById(R.id.tvRestauarntName);
        tvDate= (TextView) findViewById(R.id.tvDate);
        tvToday= (TextView) findViewById(R.id.tvToday);
        tvTomorrow= (TextView) findViewById(R.id.tvTomorrow);
        tvTime= (TextView) findViewById(R.id.tvTime);
        tvBookingSummary= (TextView) findViewById(R.id.tvBookingSummary);
        tvDateBooked= (TextView) findViewById(R.id.tvDateBooked);
        tvTimeBooked= (TextView) findViewById(R.id.tvTimeBooked);
        tvNoOfPersons= (TextView) findViewById(R.id.tvNoOfPersons);


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
    private void selectTimeAdapter() {
        ArrayAdapter adapter=new ArrayAdapter(context,R.layout.row_textview_spinner_type,timeArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectTime.setAdapter(adapter);


    }
    private void selectNumberOfPeopleAdapter() {
        ArrayAdapter adapter=new ArrayAdapter(context,R.layout.row_textview_spinner_type,numberOfPeopleArray);
        adapter.setDropDownViewResource(R.layout.row_report_type_dropdown);
        spSelectPeople.setAdapter(adapter);

    }

    private void setListeners() {
        tvBookNow.setOnClickListener(this);
        tvSelectfromCalender.setOnClickListener(this);
        spSelectPeople.setOnItemSelectedListener(this);
        spSelectTime.setOnItemSelectedListener(this);

    }

    private void setAdapter() {
        RestaurantsAdapter RestaurantsAdapter = new RestaurantsAdapter(context);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
        rvRestaurants.setLayoutManager(mLayoutManager);
        rvRestaurants.setAdapter(RestaurantsAdapter);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()){
            case R.id.tvBookNow:
                intent=new Intent(context,BookingSummaryActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
            case R.id.tvSelectfromCalender:
                pickDate();
                break;

        }
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
                SimpleDateFormat smdf = new SimpleDateFormat("dd/MM/yyyy");
                date = smdf.format(calendar.getTime());
                //selected = Long.parseLong(String.valueOf((CommonUtils.getTimeStampDate(date, "dd/MM/yyyy"))));

                tvSelectfromCalender.setText(date);
                tvDateBooked.setText(date);
               /* tvSelectTimeValue.setText(R.string.select_time);*/

                CommonUtils.savePreferenceInt(context, AppConstant.YEAR, year);
                CommonUtils.savePreferenceInt(context, AppConstant.MONTH, monthOfYear);
                CommonUtils.savePreferenceInt(context, AppConstant.DATE, dayOfMonth);
            }
        }, cYear, cMonth, cDay);
        DatePicker dp = dpd.getDatePicker();
        if (date != null) {
            dpd.getDatePicker().updateDate(CommonUtils.getPreferencesInt(context, AppConstant.YEAR), CommonUtils.getPreferencesInt(context, AppConstant.MONTH), CommonUtils.getPreferencesInt(context, AppConstant.DATE));
        } else {
            dp.setMaxDate(Calendar.getInstance().getTimeInMillis());
        }
        dpd.show();
        dpd.getDatePicker().setMinDate(System.currentTimeMillis());
        dpd.getDatePicker().setMaxDate(System.nanoTime());
        dpd.setCancelable(true);
    }

    @Override
    public void onItemSelected(AdapterView<?> adapterView, View view, int i, long l) {

        tvTimeBooked.setText(spSelectTime.getSelectedItem().toString().trim());
        tvNoOfPersons.setText(spSelectPeople.getSelectedItem().toString().trim());

    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }
}
