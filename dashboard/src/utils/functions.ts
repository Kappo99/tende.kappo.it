import { WindSensor } from "@/lib/api";

export function compressZeros(data : WindSensor[]) {
    const dataCompressed : WindSensor[] = [];

    let id = -1;
    let _id = -1;
    let frequency = -1;
    let date = "";

    for (let i = 0; i < data.length; i++) {

        if(data[i].frequency != 0 && frequency == 0) { // ultimo 0
            if(_id != id+1) {
                dataCompressed.push({id, date, frequency, _placeholder : true});
                dataCompressed.push({id, date, frequency});
            }
            dataCompressed.push(data[i]);
        } else if (data[i].frequency != 0 || frequency != 0) { //valori normali o primo 0
            dataCompressed.push(data[i]);
            if(data[i].frequency == 0) {
                _id = id;
            }
        }

        id = data[i].id;
        date = data[i].date;
        frequency = data[i].frequency;
    }

    if (frequency == 0) {
        if(data.length > 2) {
            dataCompressed.push({id, date, frequency, _placeholder : true});
        }
        if(data.length > 1) {
            dataCompressed.push({id, date, frequency});
        }
    }

    return dataCompressed;
}