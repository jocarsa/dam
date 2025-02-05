package com.jocarsa.forestgreen2.models

data class LoginResponse(
    val success: Boolean,
    val user_id: String?,
    val message: String?
)