const start = process.hrtime.bigint();

let numero = 1.00000000435;
for (let i = 0; i < 1000000000; i++) {
    numero *= 1.0000000000054;
}

const end = process.hrtime.bigint();
const duration = Number(end - start) / 1e9; // Convert nanoseconds to seconds

console.log(numero);
console.log(`Tiempo transcurrido: ${duration} segundos`);

