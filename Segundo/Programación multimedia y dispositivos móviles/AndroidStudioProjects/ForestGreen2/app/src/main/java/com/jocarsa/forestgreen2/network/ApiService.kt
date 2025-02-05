package com.jocarsa.forestgreen2.network

import com.jocarsa.forestgreen2.models.LoginResponse
import retrofit2.Call
import retrofit2.http.*

interface ApiService {
    @FormUrlEncoded
    @POST("https://forestgreen.jocarsa.com/server.php")
    fun login(
        @Field("action") action: String,
        @Field("username") username: String,
        @Field("password") password: String
    ): Call<LoginResponse>
}
