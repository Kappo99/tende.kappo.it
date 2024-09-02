// src/Dashboard.tsx
import React from 'react';
import Table from '../components/Table';

const Dashboard: React.FC = () => {
  return (
    <>
      <div className="container text-center mt-10">
        <h1 className="uppercase text-4xl lg:text-5xl font-normal">Centralina tende</h1>
      </div>
      {/* <div className="container clearfix">
        <div className="font-4 float-left">
          <div className="input-group mb-3">
            <div className="input-group-prepend">
              <span className="input-group-text" id="txtData">Data</span>
            </div>
            <input type="date" className="form-control focusOutHandle valueToGet" name="date" min="2020/07/23" max="<?=$today?>" value="<?=$dateGet?>" aria-label="Data" aria-describedby="txtData" />
          </div>
          <div className="input-group mb-3">
            <div className="input-group-prepend">
              <span className="input-group-text" id="txtValoreMin">Minimo</span>
            </div>
            <input type="number" className="form-control focusOutHandle valueToGet" name="min-value" min="0" value="<?=$minValue?>" aria-label="Minimo" aria-describedby="txtValoreMin" />
          </div>
          <div className="input-group mb-3">
            <div className="input-group-prepend">
              <span className="input-group-text" id="txtValoriConsecutivi">Consecutivi</span>
            </div>
            <input type="number" className="form-control focusOutHandle valueToGet" name="cons-value" min="0" value="<?=$consValue?>" aria-label="Consecutivi" aria-describedby="txtValoriConsecutivi" />
          </div>
        </div>
        <a href="/"><button type="button" className="btn btn-outline-danger float-right">Reset</button></a>
      </div> */}
      <Table title='Vento' />
    </>
  );
}

export default Dashboard;
