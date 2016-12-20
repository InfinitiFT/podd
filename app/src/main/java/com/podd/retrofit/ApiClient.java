package com.podd.retrofit;


import android.content.Context;
import android.util.Base64;

import java.io.IOException;
import java.io.InputStream;
import java.util.concurrent.TimeUnit;
import okhttp3.Interceptor;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.Response;
import okhttp3.logging.HttpLoggingInterceptor;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


public class ApiClient {

    public static final String BASE_URL = "http:172.16.0.9/PROJECTS/IOSNativeAppDevelopment/trunk/webservices/";

    private static Retrofit retrofit = null;




    public static Retrofit getClient(Context context) {
        if (retrofit==null) {

            String credentials = "admin:1234";

            final String basic = "Basic " + Base64.encodeToString(credentials.getBytes(), Base64.NO_WRAP);

            OkHttpClient.Builder httpClient = new OkHttpClient.Builder();
            httpClient.addInterceptor(new Interceptor() {
                @Override
                public Response intercept(Interceptor.Chain chain) throws IOException {
                    Request original = chain.request();

                    Request request = original.newBuilder()
                            .header("Content-Type", "application/json")
                            .header("Authorization",basic)
                            .method(original.method(), original.body())
                            .build();

                    return chain.proceed(request);
                }
            });


            HttpLoggingInterceptor httpLoggingInterceptor = new HttpLoggingInterceptor();
            httpLoggingInterceptor.setLevel(HttpLoggingInterceptor.Level.BODY);
            OkHttpClient client = null;
            try {
                client = new OkHttpClient.Builder()
                        .addInterceptor(httpLoggingInterceptor)
                        .readTimeout(30, TimeUnit.SECONDS)
                        .connectTimeout(30, TimeUnit.SECONDS)

                        .build();
            } catch (Exception e) {
                e.printStackTrace();
            }


            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .client(client)

                    .build();

        }
        return retrofit;
    }


}
