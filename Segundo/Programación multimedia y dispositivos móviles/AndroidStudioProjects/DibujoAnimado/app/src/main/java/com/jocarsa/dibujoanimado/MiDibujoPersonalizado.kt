package com.jocarsa.dibujoanimado

import android.content.Context
import android.graphics.Canvas
import android.graphics.Color
import android.graphics.Paint
import android.os.Parcel
import android.os.Parcelable
import android.util.AttributeSet
import android.view.SurfaceHolder
import android.view.SurfaceView
import kotlin.random.Random

class MiDibujoPersonalizado(context: Context, attrs: AttributeSet? = null) : SurfaceView(context, attrs), SurfaceHolder.Callback {
    private var x: Float = 100f
    private var y: Float = 100f
    private var direccion: Float = 0f

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
    // BUCLE
    override fun surfaceCreated(holder: SurfaceHolder) {
        Thread {
            while (true) {
                val canvas = holder.lockCanvas()
                canvas?.let {
                    x += Math.cos(direccion.toDouble()).toFloat()
                    y += Math.sin(direccion.toDouble()).toFloat()
                    direccion += Random.nextFloat() * 0.2f - 0.1f // Ajuste de -0.1 a 0.1 radianes

                    pinta(it)
                    holder.unlockCanvasAndPost(it)
                }
                Thread.sleep(50) // Cambia el color cada 500ms
            }
        }.start()
    }

    // Dibuja formas en el lienzo
    private fun pinta(canvas: Canvas) {
        canvas.drawColor(Color.WHITE) // Fondo blanco

        canvas.drawCircle(x, y, 150f, pinturaroja)

    }

    // No es necesario implementar nada aquí para este ejemplo
    override fun surfaceChanged(holder: SurfaceHolder, format: Int, width: Int, height: Int) {}

    override fun surfaceDestroyed(holder: SurfaceHolder) {}
}