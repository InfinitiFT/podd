package com.podd.retrofit;



import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;


/**
 * The interface Api interface.
 */
public interface ApiInterface {

    /**
     * Get cuisine restaurant list call.
     *
     * @param jsonRequest the json request
     * @return the call
     */

    @POST("restaurant_list.php")
    public  Call<JsonResponse>getRestautantsList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    public  Call<JsonResponse>getCuisineRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    public Call<JsonResponse>getDietaryRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    public Call<JsonResponse>getMealRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    public Call<JsonResponse>getLocationRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    public Call<JsonResponse>getAmbienceRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_details.php")
    public Call<JsonResponse>getRestaurantDetails(@Body JsonRequest jsonRequest);

    @POST("time_interval.php")
    public Call<JsonResponse>getRestaurantTimeInterval(@Body JsonRequest jsonRequest);

    @POST("restaurant_booking.php")
    public Call<JsonResponse>sendOtp(@Body JsonRequest jsonRequest);


    @POST("otp_verification.php")
    public Call<JsonResponse>otpVerification(@Body JsonRequest jsonRequest);

    @POST("resend_otp.php")
    public Call<JsonResponse>resendOtp(@Body JsonRequest jsonRequest);



    /*@POST("signup")
    Call<JsonResponse> getSignUp(@Body JsonRequest loginRequestModel);

    @POST("changePassword")
    Call<JsonResponse> getChangePassword(@Header("token") String token, @Body JsonRequest changePasswordRequestModel);

    @POST("login")
    Call<JsonResponse> getLogin(@Body JsonRequest loginModel);

    @POST("tutorpage")
    Call<JsonResponse> getSearchTutor(@Header("token") String token, @Body JsonRequestTutor searchTutorModel);

    @POST("mentorpage")
    Call<JsonResponse> getSearchMentor(@Header("token") String token, @Body JsonRequestTutor searchTutorModel);

    @POST("forgotPass")
    Call<JsonResponse> getforgotPass(@Header("token") String token, @Body JsonRequest forgotPassword);


    @POST("setAppointTime")
    Call<JsonResponse> setAppointTime(@Header("token") String token, @Body JsonRequest setAppointmentTime);


    @POST("TakeAppointment")
    Call<JsonResponse> setTakeAppointment(@Header("token") String token, @Body JsonRequest takeAppointment);

    @POST("AvailableTiming")
    Call<JsonResponse> getAvailableTime(@Header("token") String token, @Body JsonRequest availableTime);

    @POST("changeNotificationStatus")
    Call<JsonResponse> getNotificationStatus(@Header("token") String token, @Body JsonRequest notificationStatus);

    @POST("calculatePoint")
    Call<JsonResponse> calculatePoints(@Header("token") String token, @Body JsonRequest calculatePoints);

    @POST("bookinghistory")
    Call<BookingHistoryModel> getBookingHistory(@Header("token") String token, @Body JsonRequest bookingHistory);

    @POST("paynow")
    Call<JsonResponse> getPayNow(@Header("token") String token, @Body JsonRequest payNow);

    @POST("editrating")
    Call<JsonResponse> getRating(@Header("token") String token, @Body JsonRequest payNow);

    @POST("comments")
    Call<JsonResponseComment> getComment(@Header("token") String token, @Body JsonRequest comment);

    @POST("tutorpagebuy")
    Call<LessonModal> getLessonBuy(@Header("token") String token, @Body JsonRequest lessonBuy);

    @POST("lessonBuy")
    Call<JsonResponse> getBuyLesson(@Header("token") String token, @Body JsonRequest buyLesson);

    @POST("bankdetail")
    Call<JsonResponseBankDetail> getBankDetail(@Header("token") String token, @Body JsonRequest bankDetail);

    @POST("paypalDetail")
    Call<JsonResponsePaypal> getPaypalDetail(@Header("token") String token, @Body JsonRequest paypal);
    @POST("addlessonschedule")
    Call<JsonResponse> getAddLessonSchedule(@Header("token") String token, @Body JsonRequest addLesson);

    @POST("mentorhome")
    Call<HomeModel> getMentorHome(@Header("token") String token, @Body JsonRequest homeMentor);

    @POST("studenthome")
    Call<HomeModel> getStudentHome(@Header("token") String token, @Body JsonRequest homeMentor);

    @POST("allsubject")
    Call<TakeAppoint> getAllSubject(@Header("token") String token, @Body JsonRequest allSubject);


    @POST("PointSharing")
    Call<JsonResponse> getRewardPoint(@Header("token") String token, @Body JsonRequest jsonRequest);

    @POST("chatHistory")
    Call<JsonResponseChatHistory> getChatHistory(@Header("token") String token, @Body JsonRequest jsonRequest);

    @POST("logout")
    Call<JsonResponse> getLogout(@Header("token") String token, @Body JsonRequest logout);

    @POST("languageExchange")
    Call<JsonResponse> getToMentor(@Header("token") String token, @Body JsonRequest imageapi);
    @POST("imageApi")
    Call<JsonResponseImage> getUserImage(@Header("token") String token, @Body JsonRequest imageapi);

    @POST("notificationHistory")
    Call<JsonResponseNotification> getNotification(@Header("token") String token, @Body JsonRequest notiapi);

    @GET("countryname")
    Call<CountryModal> countryName(@Header("token") String token);

    @GET("countryname")
    Call<CountryListModel> countryListName(@Header("token") String token);

    @GET("profile/{id}")
    Call<ProfileModal> calledGetProfile(@Header("token") String token, @Path("id") String id);

    @GET("profile/{id}")
    Call<TutorProfileModel> calledTutorProfile(@Header("token") String token, @Path("id") String id);

    @GET("profile/{id}")
    Call<MentorProfileModel> calledMentorProfile(@Header("token") String token, @Path("id") String id);

    @GET("getPoint/{id}")
    Call<JsonResponse> getPointApi(@Header("token") String token, @Path("id") String id);

    @GET("http://api.fixer.io/latest?base=USD")
    Call<JsonResponse> calculateCurrencyPoints(@Header("token") String token);

    @GET("termsView")
    Call<JsonResponse> getTerms();


    @GET("tutorSubjectList")
    Call<JsonResponseSubjectList> getSubjectList();



    @PUT("edit/{id}")
    Call<JsonResponse> calledEditProfile(@Header("token") String token, @Path("id") String id, @Body JsonRequest editProfile);

    @PUT("edit/{id}")
    Call<JsonResponse> calledEditTutor(@Header("token") String token, @Path("id") String id, @Body TutorEditProfileResult editProfile);

    @PUT("edit/{id}")
    Call<JsonResponse> calledEditMentor(@Header("token") String token, @Path("id") String id, @Body MentorEditProfileResult editProfile);

    @POST("ViewStudent")
    Call<ViewUserResult> getStudentUserList(@Header("token") String token, @Body JsonRequest viewStudentList);

    @POST("appointments")
    Call<AppointmentModel> getAppointmentsList(@Header("token") String token, @Body JsonRequest appointments);

    @POST("AcceptUser")
    Call<AcceptDeclineResponse> acceptUser(@Header("token") String token, @Body JsonRequest AcceptUser);

    @POST("RejectUser")
    Call<AcceptDeclineResponse> rejectUser(@Header("token") String token, @Body JsonRequest RejectUser);

    @POST("checkemail")
    Call<TutorEmailCheckResponse> emailCheck(@Body TutorEmailCheckRequest loginModel);

    @GET("agreementView")
    Call<ExchangeAgreementResponse> callExchangeAgreement();

    @GET("showallQuestions")
    Call<LanguageHelpResponse> callShowAllQuestions(@Header("token") String token);

    @GET("studentmylesson/{id}")
    Call<StudentMyLessonResponse> callStudentMyLesson(@Header("token") String token, @Path("id") String id);

    @POST("LanguageHelp")
    Call<ResultResponse> languageHelp(@Header("token") String token, @Body LanguageHelpRequest languageHelpRequest);

    @POST("AnswerTheQuestion")
    Call<AnswerResponse> answerTheQuestions(@Header("token") String token, @Body AllAnswerRequest allAnswerRequest);

    @POST("studentlessonsearch")
    Call<LessonSearchResponse> studentLessonSearch(@Header("token") String token, @Body StudentLessonSearchRequest studentLessonSearchRequest);

    @POST("stripe")
    Call<StripeJsonResponse> getStripePay(@Header("token") String token, @Body JsonRequest jsonRequest);*/

}
