package com.jocarsa.dibujo

import android.content.Context
import android.graphics.Canvas
import android.graphics.Color
import android.graphics.Paint
import android.os.Parcel
import android.os.Parcelable
import android.util.AttributeSet
import android.view.SurfaceHolder
import android.view.SurfaceView

class MiDibujoPersonalizado(context: Context, attrs: AttributeSet? = null) : SurfaceView(context, attrs), SurfaceHolder.Callback {

    // Configuración de Paint para el dibujo
    private val pinturaroja = Paint().apply {
        color = Color.RED
        style = Paint.Style.STROKE
        strokeWidth = 8f
    }
    private val pinturaverde = Paint().apply {
        color = Color.GREEN
        style = Paint.Style.STROKE
        strokeWidth = 8f
    }

    init {
        // Configurar el SurfaceHolder
        holder.addCallback(this)
    }

    // Método para dibujar cuando el SurfaceView se crea
    override fun surfaceCreated(holder: SurfaceHolder) {
        val canvas = holder.lockCanvas()
        canvas?.let {
            drawShapes(it)
            holder.unlockCanvasAndPost(it)
        }
    }

    // Dibuja formas en el lienzo
    private fun drawShapes(canvas: Canvas) {
        canvas.drawColor(Color.WHITE) // Fondo blanco

        canvas.drawCircle(width / 2f, height / 2f, 150f, pinturaroja)
        canvas.drawCircle(50f, 50f, 50f, pinturaroja)

        canvas.drawRect(100f, 100f, 300f, 300f, pinturaroja)

        canvas.drawLine(50f, 400f, 300f, 600f, pinturaverde)

        canvas.drawText("Hola",200f,200f,pinturaroja)
    }

    // No es necesario implementar nada aquí para este ejemplo
    override fun surfaceChanged(holder: SurfaceHolder, format: Int, width: Int, height: Int) {}

    override fun surfaceDestroyed(holder: SurfaceHolder) {}
}