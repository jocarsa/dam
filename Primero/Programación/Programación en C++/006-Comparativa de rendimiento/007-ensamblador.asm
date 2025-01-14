section .data
    numero dq 1.00000000435      ; Initial number (double precision)
    factor dq 1.0000000000054    ; Multiplication factor
    iterations equ 1000000000    ; Number of iterations
    result_msg db "Resultado: %lf", 0
    time_msg db "Tiempo transcurrido: %lf segundos", 0

section .bss
    start_time resq 1
    end_time resq 1

section .text
    global _start
    extern printf, clock

_start:
    ; Get start time
    call clock
    mov qword [start_time], rax

    ; Load initial value into the FPU
    fld qword [numero]

    ; Load factor into the FPU
    fld qword [factor]

    ; Perform the loop
    mov ecx, iterations          ; Set loop counter
loop_start:
    fmul st0, st1                ; Multiply ST(0) by ST(1)
    loop loop_start              ; Decrement ECX and repeat

    ; Store the result back into memory
    fstp qword [numero]

    ; Get end time
    call clock
    mov qword [end_time], rax

    ; Calculate elapsed time (end_time - start_time)
    mov rax, qword [end_time]
    sub rax, qword [start_time]
    mov rdi, time_msg
    mov rsi, rax
    call printf

    ; Print the result
    mov rdi, result_msg
    fld qword [numero]
    fstp qword [rsp-8]
    movq xmm0, qword [rsp-8]
    call printf

    ; Exit program
    mov rax, 60                  ; sys_exit
    xor rdi, rdi                 ; Exit code 0
    syscall

