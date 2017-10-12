import React from "react";
import Preloader from "../../components/preloader/preloader";
import DlgFilter from "./partial/delegation.filter";
import * as services from "../services/services";

class DlgApp extends React.Component{
    constructor(props){
        super();
        this.state={
            filter: {
                games: [],
                current: {},
                year: new Date()
            },
            isLoading: false
        }
        this.onFilterChange = this.changeFilter.bind(this);
    }

    changeFilter(field, value){
        var newFilter = this.state.filter;
        newFilter[field] = value;
        this.setState({filter: newFilter});      
    }

    getGames(){
        this.setState({isLoading: true});
        services.getGames().then(data => {
            this.changeFilter("games", JSON.parse(data));
            this.setState({isLoading: false});
        })
    }   
    
    componentDidMount(){
        this.getGames();
    }

    render(){
        return <div className="row">
            <div className="col-md-12">
                <h4>Делегація</h4>
                <div className="row">
                    <div className="col-md-10">
                        <DlgFilter filter={this.state.filter} onChange={this.onFilterChange} onFilter={() => null} />
                    </div>
                    <div className="col-md-2">

                    </div>
                </div>
                <Preloader loading={this.state.isLoading} />
            </div>
        </div>
    }
}
export default DlgApp;