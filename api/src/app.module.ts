// src/app.module.ts
import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { WindModule } from './wind/wind.module';
import { WindSensor } from './wind/wind.entity';
import "reflect-metadata";

@Module({
  imports: [
    TypeOrmModule.forRoot({
      type: 'mysql', // Usa il tuo database (es: mysql, postgres)
      host: 'tende.kappo.it', //'localhost',
      port: 3306,
      username: 'u253831929_SmartHome',
      password: 'SmartHomeDB99',
      database: 'u253831929_smarthome',
      entities: [WindSensor],
      synchronize: true, // Imposta a false in produzione
    }),
    WindModule,
  ],
})
export class AppModule {}
