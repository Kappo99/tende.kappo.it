// src/Table.tsx
import React, { useState } from 'react';
import { FaRegSquareMinus, FaRegSquarePlus } from 'react-icons/fa6';
import { useSensors } from '../context/SensorContext';

interface IProps {
  title: string
}

const Table: React.FC<IProps> = (props) => {
  const [show, setShow] = useState(true);
  const [rowsLimit, setRowsLimit] = useState(5000);
  const {sensors, fetchSensors} = useSensors();

  return (
    <div className='container my-12'>
      <div className='w-full flex items-center justify-between gap-2'>
        <span className='cursor-pointer hover:opacity-70' onClick={() => setShow(!show)}>
          {show ? <FaRegSquareMinus size={28} /> : <FaRegSquarePlus size={28} />}
        </span>
        <h3 className='flex-1 uppercase inline text-2xl lg:text-3xl font-normal'>
          <span className='hidden md:inline'>Sensore</span> {props.title}
        </h3>
        <div className='flex items-center'>
          <div className='hidden md:block'>
            <span className='bg-gray-200 border border-gray-300 rounded-l-md px-2 py-1.5'>Righe</span>
          </div>
          <input className='w-28 bg-white border border-gray-300 border-l-0 rounded-r-md pl-2'
            type='number'
            min='0'
            value={rowsLimit}
            onChange={(e) => setRowsLimit(parseInt(e.target.value))}
          />
        </div>
      </div>
      {show &&
        <table className='w-full bg-white text-center border border-neutral-950 shadow-lg'>
          <thead>
            <tr>
              <th>ID</th>
              <th>Data</th>
              <th>Frequenza</th>
            </tr>
          </thead>
          <tbody>
            {[
              { data: '2024-09-01', frequenza: 0 },
              { data: '2024-09-01', frequenza: 1 },
              { data: '2024-09-01', frequenza: 2 },
              { data: '2024-09-01', frequenza: 3 },
              { data: '2024-09-01', frequenza: 4 },
              { data: '2024-09-01', frequenza: 5 },
            ].map(({ data, frequenza }, index) => {
              return (
                <tr key={index}>
                  <td>{index}</td>
                  <td>{data}</td>
                  <td>{frequenza}</td>
                </tr>
              )
            })}
          </tbody>
          {/* <?php
        $whereSQL = "";
        if ($dateGet != 0)
        $whereSQL .= "WHERE date LIKE '$dateGet%'";
        if ($minValue != 0)
			$whereSQL .= ($whereSQL == "" ? "WHERE" : "AND")." frequency >= $minValue";
        $query = "SELECT id, date, frequency FROM `smart-home_wind-sensor` $whereSQL ORDER BY date DESC LIMIT $windLimit";
        $wind = getQueryResult($query);
        if ($wind != null) {
          $_id = null;
        $id = null;
        $freq = -1;
        $date = null;
        foreach ($wind as $wd) {
				if ($wd["frequency"] != 0 && $freq == 0) { // ultimo valore 0
					if ($_id != $id + 1) {
          print_serie_0($id, $date, $freq);
					}
        print_vento($wd["id"], $wd["date"], $wd["frequency"]);
				}
        else if ($wd["frequency"] != 0 || $freq != 0) { // valori normali (primo 0 o valori != 0)
          print_vento($wd["id"], $wd["date"], $wd["frequency"]);
        if ($wd["frequency"] == 0)
        $_id = $id;
				}
        $id = $wd["id"];
        $date = $wd["date"];
        $freq = $wd["frequency"];
			}
        if ($freq == 0) {
          print_serie_0($id, $date, $freq);
			}
		}
        else {
	?>
			<div className="row no-gutters">
				<div className="col-12 font-italic text-muted">Non sono presenti valori per la data selezionata</div>
			</div>
	<? php
		}
	?> */}
        </table>
      }
    </div>
  );
}

export default Table;
